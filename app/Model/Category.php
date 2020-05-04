<?php

namespace DevWeb\Model;

class Category extends Model
{
  protected $tb = 'tb_site.categorias';
  protected $used_fields = ['name'];
  protected $is_orded_by_id = true;
}

// EOF
