<?php

namespace DevWeb\Model;

class Notice extends Model
{
  protected $tb = 'tb_site.noticias';
  protected $used_fields = ['title', 'conteudo', 'capa', 'categoria_ref'];
  protected $is_orded_by_id = true;
}

// EOF
