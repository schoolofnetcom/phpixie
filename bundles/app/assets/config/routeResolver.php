<?php

return array(
    'type'      => 'group',
    'defaults'  => array('action' => 'default'),
    'resolvers' => array(

        'messages' => [
            'path'=> 'page(/<page>)',
            'defaults' => ['processor'=>'messages']
        ],
        
        'action' => array(
            'path' => '<processor>/<action>'
        ),

        'processor' => array(
            'path'     => '(<processor>)',
            'defaults' => array('processor' => 'greet')
        ),
    )
);
