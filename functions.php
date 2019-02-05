<?php
/*
Plugin Name: meta-in-accordion
Plugin URI:
Description: 動画のテキストコンテンツをアコーディオンで表示するためのプラグイン
Version: 1.4.0
Author: KaiOno
Author URI: business-online-channel.com
License: GPL2
*/

function meta_accordion_scripts() {
  $plugin_dir = plugin_dir_url( __FILE__ );

  if(is_single()){
      wp_enqueue_style( 'meta-in-accordion-css', $plugin_dir . 'css/mia.css', false, '1.1.0' );
      wp_enqueue_script( 'meta-in-accordion-js', $plugin_dir . 'js/mia.js', array(), '1.1.1' , true );
  }
}
add_action( "wp_enqueue_scripts", "meta_accordion_scripts" );

// function show_accordion( $content ) {
//   global $post;
//   $accordion_content = get_post_meta($post->ID, 'accordion_txt', true);
//   if($accordion_content){
//     $accordion = '<div class="openaccordion_btn">この動画の内容を文字で読む</div>
//   <div class="accordion_txt">'.nl2br( $accordion_content ).'</div>';
//   }
//   else $accordion = "";
//   $content = $content.$accordion;
//   return $content;
// }
// add_filter( "the_content", "show_accordion");

//管理画面に動画の文字起こしを入力するカスタムフィールドを追加する
function add_accordion_txt(){
 if(function_exists('add_accordion_txt')){
  add_meta_box('accordion_text', '動画文字起こし', 'insert_accordion_txt', 'post', 'normal', 'high');
 }
}

function insert_accordion_txt(){
 global $post;
 wp_nonce_field(wp_create_nonce(__FILE__), 'my_nonce');
 echo '<label class="hidden" for="accordion_txt">概要テキスト</label><textarea id="accordion_txt" name="accordion_txt" rows="2" cols="60" value="'.esc_html(get_post_meta($post->ID, 'accordion_txt', true)).'" style="width:100%;">'.esc_html(get_post_meta($post->ID, 'accordion_txt', true)).'</textarea>';
 echo '<p>動画のテキストをこちらに記入します。</p>';
}
add_action('admin_menu', 'add_accordion_txt');

// function save_accordion_txt( $post_id ) {
// 	if(!empty($_POST['accordion_txt'])){ //題名が入力されている場合
// 		update_post_meta($post_id, 'accordion_txt', $_POST['accordion_txt'] ); //値を保存
// 	}else{ //題名未入力の場合
// 		delete_post_meta($post_id, 'accordion_txt'); //値を削除
// 	}
// }
// add_action('save_post', 'save_accordion_txt');

function update_accordion_txt( $new_status, $old_status, $post ) {
  $post_id = get_the_ID();
  if(!empty($_POST['accordion_txt'])){ //題名が入力されている場合
    update_post_meta($post_id, 'accordion_txt', $_POST['accordion_txt'] ); //値を保存
  }else{ //題名未入力の場合
    delete_post_meta($post_id, 'accordion_txt'); //値を削除
  }
}
add_action('transition_post_status' , 'update_accordion_txt' , 10 , 3);

add_shortcode('show-accordion', function($post_id){
  $accordion_content = get_post_meta(get_the_ID(), 'accordion_txt', true);
  if($accordion_content){
    $accordion_content = '<div class="openaccordion_btn">この動画の内容を文字で読む</div>
    <div class="accordion_txt">'.nl2br( $accordion_content ).'</div>';
  }
  else $accordion_content = "";

  return $accordion_content;
});
?>
