<?php

namespace DevWeb\Model;

class Depoiment extends Model
{
  protected $tb = 'tb_site.depoimentos';
  protected $used_fields = ['depoimento', 'name'];
  protected $is_orded_by_id = true;
}

// EOF
