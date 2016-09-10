<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ava {

	// public function __construct() {
	// 	parent::__construct();
		
	// }

	function getConfig(){
        $t='{
    modules:{
        pages:{
            title: "страницы",
            fields:{
                "name":{
                    "type": "text",
                    length: "200"
                },
                "description":{
                    type: "textarea",
                    length: "inf",
                    level:0
                }
            },
            submenu:"users",
        },
        //Пользователи
        users:{
            title: "Пользователи",
            fields:{
                "name":{
                    type: "text",
                    length: "200"
                },
                "description":{
                    type: "textarea",
                    length: "inf",
                    level:0
                },
                "photo1":{
                    title: "Фото 1",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo2":{
                    title: "Фото 2",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo3":{
                    title: "Фото 3",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo4":{
                    title: "Фото 4",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                }
            }
        },
        //не пользователи!!
        nousers:{
            title: "Не Пользователи",
            fields:{
                "name":{
                    type: "text",
                    length: "200"
                },
                "description":{
                    type: "textarea",
                    length: "inf",
                    level:0
                },
                "photo1":{
                    title: "Фото 1",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo2":{
                    title: "Фото 2",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo3":{
                    title: "Фото 3",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                },
                "photo4":{
                    title: "Фото 4",
                    type: "img",                    
                    resize: {
                        ta:"220",
                        tb:"500"
                    }
                }
            }
        }
    }
}';
    print_r(json_decode($t));
    }
}
