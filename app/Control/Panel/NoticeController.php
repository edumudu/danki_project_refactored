<?php

namespace DevWeb\Control\Panel;

class NoticeController extends ControllerPanel
{
  protected $tb = 'tb_site.noticias';
  protected $used_fields = ['title', 'conteudo', 'capa', 'slug', 'date'];
  protected $base_uri = 'notice';
}

// EOF
