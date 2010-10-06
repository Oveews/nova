<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Main extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_main',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the values to be passed to the views
		$vars = array(
			'template' => array(
				'skin' => $this->skin,
				'sec' => 'main'),
			'layout' => array(
				'skin'	=> $this->skin,
				'sec'	=> 'main'),
		);
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', $vars['template']);
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options->sim_name.' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_main', $vars['layout']);
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'main');
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash			= FALSE;
		$this->template->layout->content		= FALSE;
		$this->template->layout->panel_1		= FALSE;
		$this->template->layout->panel_2		= FALSE;
		$this->template->layout->panel_3		= FALSE;
		$this->template->layout->panel_workflow	= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_index', $this->skin, 'main', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('main_index_js', $this->skin, 'main', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__("main"));
		$data->header = Jelly::query('message', 'welcome_head')->limit(1)->select()->value;
		$data->message = Jelly::query('message', 'welcome_msg')->limit(1)->select()->value;
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_contact()
	{
		if (isset($_POST['submit']))
		{
			$validate = Validate::factory($_POST)
				->rule('email', 'not_empty')
				->rule('email', 'email')
				->rule('name', 'not_empty')
				->rule('message', 'not_empty'));
				
			if ($validate->check())
			{
				// clear the errors (if there are any)
				$this->session->delete('errors');
				
				// set the data for the email
				$emaildata = new stdClass;
				$emaildata->name = trim(Security::xss_clean($_POST['name']));
				$emaildata->email = trim(Security::xss_clean($_POST['email']));
				$emaildata->message = trim(Security::xss_clean($_POST['message']));
				$emaildata->cc = trim(Security::xss_clean($_POST['ccme']));
				
				// send the email
				$email = $this->_email('contact', $emaildata);
				
				// set the flash message
				$this->template->layout->flash = Submit::show_flash( (int) $email, __("your information"), __("submitted"), $this->skin, 'main');
			}
			else
			{
				// set the errors
				$session->set('errors', $validate->errors('register'));
			}
		}
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_contact', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(__("contact us"));
		$data->header = ucwords(__("contact us"));
		$data->message = Jelly::query('message', 'contact')->limit(1)->select()->value;
		
		// fields
		$data->inputs = array(
			'name' => array(
				'id' => 'name',
				'placeholder' => ucfirst(__("name"))),
			'email' => array(
				'type' => 'email',
				'id' => 'email',
				'placeholder' => ucfirst(__("email address"))),
			'message' => array(
				'id' => 'message',
				'placeholder' => ucfirst(__("let us know what your comment or question is")),
				'rows' => 12),
			'submit' => array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit'),
		);
		
		// send the response
		$this->request->response = $this->template;
		
		
		
		
		
		
		
		/*
		if (isset($_POST['submit']))
		{
		
			$array = array(
				'to'		=> $this->input->post('to'),
				'name'		=> $this->input->post('name'),
				'email'		=> $this->input->post('email'),
				'subject'	=> $this->input->post('subject'),
				'message'	=> $this->input->post('message')
			);
			
			if ($array['to'] == FALSE || $array['email'] == FALSE || $array['message'] == FALSE || $array['to'] == '0')
			{
				$flash['status'] = 'error';
				
				if ($array['to'] == '0')
				{
					$flash['message'] = lang_output('flash_contact_recipient');
				}
				else
				{
					$message = sprintf(
						lang('flash_empty_fields'),
						lang('flash_fields_all'),
						lang('actions_send'),
						lang('labels_email')
					);
					
					$flash['message'] = text_output($message);
				}
			}
			else
			{
				
				$email = ($this->options['system_email'] == 'on') ? $this->_email('contact', $array) : FALSE;
				
				if ($email === FALSE)
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('labels_contact')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
				else
				{
					$message = sprintf(
						lang('flash_success'),
						ucfirst(lang('labels_contact')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
			}
			
			
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		
		$data['header'] = ucwords(lang('actions_contact') .' '. lang('labels_us'));
		$data['msg'] = $this->msgs->get_message('contact');
		
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		if ($this->options['system_email'] == 'off')
		{
			$data['button']['submit']['disabled'] = 'disabled';
		}
		
		$data['inputs'] = array(
			'name' => array(
				'name' => 'name',
				'id' => 'name'),
			'email' => array(
				'name' => 'email',
				'id' => 'email'),
			'subject' => array(
				'name' => 'subject',
				'id' => 'subject'),
			'message' => array(
				'name' => 'message',
				'id' => 'message',
				'rows' => 12)
		);
		
		$data['values']['to'] = array(
			0 => ucwords(lang('labels_please') .' '. lang('actions_choose') .' '. lang('order_one')),
			1 => ucwords(lang('global_game_master')),
			2 => ucwords(lang('global_command_staff')),
			3 => ucwords(lang('global_webmaster')),
		);
		
		$data['label'] = array(
			'send' => ucwords(lang('actions_send') .' '. lang('labels_to')),
			'name' => ucwords(lang('labels_name')),
			'email' => ucwords(lang('labels_email_address')),
			'subject' => ucwords(lang('labels_subject')),
			'message' => ucwords(lang('labels_message')),
			'nosubmit' => lang('flash_system_email_off_disabled'),
		);
		*/
	}
	
	public function action_credits()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_credits', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(__("site credits"));
		$data->header = ucwords(__("site credits"));
		
		// non-editable credits
		$credits_perm = Jelly::query('message', 'credits_perm')->limit(1)->select()->value;
		$credits_perm.= "\r\n\r\n".Jelly::query('catalogueskinsec')->defaultskin('main')->select()->skin->credits;
		$credits_perm.= "\r\n\r\n".Jelly::query('cataloguerank', $this->rank)->limit(1)->select()->credits;
		
		// credits
		$data->credits_perm = nl2br($credits_perm);
		$data->credits = Jelly::query('message', 'credits')->limit(1)->select()->value;
		
		// should we show an edit link?
		$data->edit = (Auth::is_logged_in() AND Auth::check_access('site/messages', FALSE))
			? TRUE
			: FALSE;
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function join()
	{
		# code...
	}
	
	public function news()
	{
		# code...
	}
	
	public function action_viewnews($id = '')
	{
		# TODO: need to handle comment moderation
		
		// sanitize the id
		$id = ( ! is_numeric($id)) ? FALSE : $id;
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_viewnews', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (isset($_POST['submit']))
		{
			// additional pieces of info that need to go on the end of the POST array
			$additional = array(
				'author_user' => $this->session->get('userid', 1),
				'author_character' => $this->session->get('main_char', 1),
				'news' => $id
			);
			
			// what comes off the POST array
			$pop = array('submit');
			
			// submit the comment
			$submit = Submit::create($_POST, 'newscomment', $additional, $pop);
			
			// show the appropriate flash message
			$this->template->layout->flash_message = Submit::show_flash($submit, __('label.comment'), __('action.added'), $this->skin, 'main');
		}
		
		// grab the news item referenced in the url
		$news = Jelly::select('news', $id);
		
		// figure out what the previous item is
		$prev = Jelly::select('news')
			->where('id', '<', $id)
			->order_by('id', 'desc');
			
		( ! Auth::is_logged_in()) ? $prev->where('private', '=', 'n') : FALSE;
		
		$prev = $prev->load();
		
		// figure out what the next item is
		$next = Jelly::select('news')
			->where('id', '>', $id)
			->order_by('id', 'desc');
			
		( ! Auth::is_logged_in()) ? $next->where('private', '=', 'n') : FALSE;
		
		$next = $next->load();
		
		if ($news->loaded())
		{
			// grab the news object
			$data->news = $news;
			
			// grab the news comments for this news item
			$comments = Jelly::select('newscomment')
				->where('news', '=', $id)
				->where('status', '=', 'activated')
				->order_by('date', 'desc')
				->execute();
			
			if ($comments)
			{
				$data->comments = array();
				
				foreach ($comments as $c)
				{
					$data->comments[] = $c;
				}
			}
			
			// build the prev/next items
			$data->prev = $prev->id;
			$data->next = $next->id;
			
			// build the images portion of the object
			$data->images = array(
				'rss' => array(
					'src' => Location::image($this->images['main.rss'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('abbr.rss'),
						'class' => '')),
				'prev' => array(
					'src' => Location::image($this->images['main.previous'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.previous'),
						'title' => ucfirst(__('word.previous')),
						'class' => '')),
				'next' => array(
					'src' => Location::image($this->images['main.next'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.next'),
						'title' => ucfirst(__('word.next')),
						'class' => '')),
				'comment'	=> array(),
			);
			
			// figure out if they're allowed to manage news items
			$data->edit = FALSE;
			
			if (Auth::check_access('manage/news', FALSE))
			{
				$level = Auth::get_access_level('manage/news');
				
				$data->edit = ($level == 2 OR ($level == 1 AND ($news->news_author_user == $this->session->get('userid')))) ? TRUE : FALSE;
			}
			
			// make sure they're logged in if it's a private news item
			if ($news->private == 'y' AND ! Auth::is_logged_in())
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item'));
				$data->header = __('error.header');
				$data->headerclass = ' error';
				$data->message = '<p class="fontMedium">'.__('error.private_news', array(':news' => __('global.news_item'),':users' => __('global.users'))).'</p>';
			}
			else
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item')).' - '. $news->title;
				$data->header = $news->title;
				$data->headerclass = NULL;
				$data->message = NULL;
			}
		}
		else
		{
			$this->template->title.= ucwords(__('action.view').' '.__('global.news_item'));
			$data->header = __('error.header');
			$data->headerclass = ' error';
			$data->message = '<p class="fontMedium">'.__('error.not_found', array(':item' => __('global.news_item'))).'</p>';
		}
		
		// build the controls for the comment box
		$data->inputs = array(
			'content' => array(
				'name' => 'content',
				'value' => '',
				'attr' => array(
					'id' => 'ncomment_content',
					'placeholder' => __('phrase.enter_your_comment', array(':item' => __('global.news_item'))),
					'rows' => 6)),
		);
		
		$data->buttons = array(
			'submit' => array(
				'name' => 'submit',
				'value' => ucfirst(__('action.submit')),
				'attr' => array(
					'type' => 'submit',
					'class' => 'button-main')),
		);
	}
	
	protected function _email($type, $data)
	{
		// set the email variable that'll be returned
		$email = FALSE;
		
		// make sure system email is turned on
		if ($this->options->system_email == 'on')
		{
			// set up the mailer
			$mailer = Email::setup_mailer();
			
			// create a new message
			$message = Email::setup_message();
			
			switch ($type)
			{
				case 'contact':
					// data for the view files
					$view = new stdClass;
					$view->subject = $this->options->email_subject.' '.__("email.subject.contact", array(':name' => $data->name));
					$view->content = $data->message;
					
					// set the html version
					$html = View::factory(Location::view('main_contact_em_html', $this->skin, 'main', 'email'), $view);
					
					// set the text version
					$text = View::factory(Location::view('main_contact_em_text', $this->skin, 'main', 'email'), $view);
					
					// set the message data
					$message->setSubject($view->subject);
					$message->setFrom(array($data->email => $data->name));
					$message->setTo($data->email);
					$message->setBody($html->render(), 'text/html');
					$message->addPart($text->render(), 'text/plain');
				break;
			}
			
			// send the message
			$email = $mailer->send($message);
		}
		
		return $email;
	}
}