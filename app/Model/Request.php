<?php

namespace DevWeb\Model;

class Request
{
  private $post;
  private $get;
  private $files;
  private $data;

  public function __construct()
  {
    $this->post = $_POST;
    $this->get = $_GET;
    $this->files = $_FILES;

    $this->data = array_merge($this->post, $this->get);
  }

  public function get(string $key, $default = null)
  {
    return $this->data[$key] ?? $default;
  }

  public function query () : Request
  {
    $this->data = $this->get;

    return $this;
  }

  public function body () : Request
  {
    $this->data = $this->post;

    return $this;
  }

  public function files($keys)
  {
    if(is_array($keys)) {
      return array_filter($this->data, fn($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY);
    }

    return $this->files[$keys];
  }

  public function all()
  {
    return $this->data;
  }

  public function only(array $keys) : array
  {
    return array_filter($this->data, fn($key) => in_array($key, $keys), ARRAY_FILTER_USE_KEY);
  }
}
