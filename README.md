# Template events priority extension information

## Installation

Copy the extension to phpBB/ext/rxu/templateventsort

Go to "ACP" > "Customise" > "Extensions" and enable the "Template events priority" extension.

## Usage

The extension allows other extensions to set their template event listeners priority when they share same template event.
This can be done via PHP event `rxu.templateventsort.twig_event_tokenparser_constructor` listener. Example:

```php
	class template_event_order implements EventSubscriberInterface
	{
		static public function getSubscribedEvents()
		{
			return [
				'rxu.templateventsort.twig_event_tokenparser_constructor'	=> 'set_template_event_priority',
			];
		}

		public function set_template_event_priority($event)
		{
			$template_event_priority_array = $event['template_event_priority_array'];
			$template_event_priority_array['vendor_name'] = [
				'event/navbar_header_quick_links_after' => -1,
			];
			$event['template_event_priority_array'] = $template_event_priority_array;
		}
	}
```

* The higher number - the higher tempate event listener priority value is.
* If not set, template event listener priority will be assigned to the value of 0.
* In case of equal priority values, corresponding template event listeners will be handled in default compilation order.

## License

[GPLv2](license.txt)
