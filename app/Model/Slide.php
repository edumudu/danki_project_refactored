<?php

namespace DevWeb\Model;

class Slide extends Model
{
  protected $tb = 'tb_site.slides';
  protected $used_fields = ['name', 'slide'];
  protected $is_orded_by_id = true;
}

// EOF
