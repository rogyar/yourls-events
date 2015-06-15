## API Get Url Events

YOURLS plugin that allows to get a list of visits for the requested URL with the following info of each visit:

- Click Time
- Referrer
- User Agent
- IP Address
- Country code


### Installation

- In /user/plugins, create a new folder named api-get-events
- Put the plugin.php file to this folder
- Go to the Plugins administration page and activate the plugin

### Request parameters

```PHP
[
  'action' => 'events', 
  'shorturl' => '4f', 
  'timestamp' => '2014-06-19 09:44:13'
]
```

### Response parameters

```PHP
[
  0 => 
    object(stdClass)[1748]
      public 'click_id'
      public 'click_time'
      public 'shorturl'
      public 'referrer'
      public 'user_agent'
      public 'ip_address'
      public 'country_code'
]
```

