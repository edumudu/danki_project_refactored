<?php

namespace DevWeb\Model;

class Request
{
  private $post;

  public function __construct()
  {
    $this->post = $_POST;
  }

  public function get($key, $default)
  {
    return $this->post[$key] ?? $default;
  }

  public function all()
  {
    return $this->post;
  }
}
