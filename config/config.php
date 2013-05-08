<?php

class Config {

  // The name of your project;
  // also the directory that your project is in

  const PROJECT_NAME = 'my-app';

  // Turn on error display
  
  const DEBUG = true;

  // The default username and password
  // to the Shepherd Admin Panel:
  // http://yoursite.com/admin

  const ADMIN_USER = '';
  const ADMIN_PW = '';

  // The directory for user-uploaded media
  const MEDIA_DIRECTORY = '/what';

  // The base Url to access media files
  const MEDIA_URL = '/media';

  // The directory in your webapp where you store static files
  const STATIC_DIRECTORY = '/static';

  // The base Url to access those static files
  const STATIC_URL = '';

  // The spot for your data files: XML, JSON, and so on
  const DATA_DIRECTORY = '/data';

  // Where you keep your app's view files
  const VIEWS_DIRECTORY = '/views';

  const TEMPLATES_DIRECTORY = '/templates';

  const LOGIN_URL = 'login';

}