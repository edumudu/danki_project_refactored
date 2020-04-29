<?php

namespace DevWeb\Control\Panel;

class CategoryController extends ControllerPanel
{
  protected $tb = 'tb_site.categorias';
  protected $used_fields = ['name'];
  protected $base_uri = 'category';
}

// EOF
