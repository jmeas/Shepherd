<?php

class Config {

  // The directory that your project is in

  const PROJECT_NAME = 'harmony';

  // Turn on error display
  
  const DEBUG = true;

  // The default username and password
  // to the Lovelace Admin Panel:
  // http://yoursite.com/admin

  const ADMIN_USER = '';
  const ADMIN_PW = '';

  // The directory for user-uploaded media
  const MEDIA_DIRECTORY = '/media';

  // The directory for your app's static files
  const STATIC_DIRECTORY = '/static';

  // The spot for your data files; XML, JSON, and so on
  const DATA_DIRECTORY = '/data';

  // Where you keep your app's view files
  const VIEWS_DIRECTORY = '/views';

  const TEMPLATES_DIRECTORY = '/templates';

  const LOGIN_URL = 'login';

}