<?php

namespace DevWeb\Control\Panel;

class DepoimentosController extends ControllerPanel
{
  protected $tb = 'tb_site.depoimentos';
  protected $used_fields = ['depoimento', 'name'];
  protected $base_uri = 'depoiments';
}

// EOF
