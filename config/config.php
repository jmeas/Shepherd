<?php

class Config {

  // The directory that your project is in
  const PROJECT_NAME = 'myapp';

  // If your site is in a directory other than the root.
  // For instance, if your app is located at www.example.com/myapp
  // the BASE_URL would be myapp
  const BASE_URL = '';

  // Turn on error display. This feature is very limited.
  const DEBUG = true;

  // The directory to access user-uploaded media
  const MEDIA_DIRECTORY = '/media';

  // The directory for your app's static files
  const STATIC_DIRECTORY = '/static';

  // Where you keep your app's view files
  const VIEWS_DIRECTORY = '/views';

  // Useful PHP scripts you might reference across your views
  const UTILS_DIRECTORY = '/utils';

  // Where you store your templates
  const TEMPLATES_DIRECTORY = '/templates';

}