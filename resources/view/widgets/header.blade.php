<?php $navbar = new \Illuminate\Support\Fluent([
        'id'    => 'formbuilder',
        'title' => 'Formbuilder',
        'url'   => handles('orchestra::formbuilder'),
        'menu'  => view('pta/formbuilder::widgets._menu'),
]); ?>

@decorator('navbar', $navbar)

<br>
