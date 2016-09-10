<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
title-название
fields-массив полей
tree-разрешить дерево	
editonly - только редактивать. запрет на создание и удаление
hide_meta - 	не показывать поля мета тегов

Поля(fields):
	type
	title
	length
	readonly- запрет на редактирование поля
	quickedit - возможность быстрого редактирования без залезания внутрь карочки по Shift+click

Типы полей:
	text
	textarea
	img имеет свойство "resize" => array('w200','h40') - будет создано три(!) тубнейла с префиксом w200 - по ширине 200px и h40 - 40 пикселей по высоте и один на первьюшку в админку
	wysiwyg - wysiwyg редактор

*/
$config['ava::modules'] = array(
	"config"=>array(
		"title" => "Настройки",
		"fields" => array(			
			"value" => array(
				"type"=>"textarea",
				"title"=>"Значение",
				"length" => "200"
				),	
			"ident" => array(
				"type"=>"text",
				"title"=>"Идентификатор",
				"readonly"=>0			
				),			
		),
		"quickedit"=>0,
		"tree" => 1,
		"editonly"=>0,
		"hide_meta"=>1
		),		
	"pages"=>array(
		"title" => "Страницы",
		"fields" => array(			
			"desc" => array(
				"type"=>"wysiwyg",
				"length" => "200",
				"title"=>"Значение",
				),
			"photo" => array(
				"type"=>"img",
				"resize" => array('w200','h40')
				),							
			"description" => array(
				"type"=>"textarea",
				"length" => "200"
				)
		),
		"tree" => 1,
		"quickedit"=>1,
	),		
);


?>