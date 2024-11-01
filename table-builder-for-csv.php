<?php
/*
Plugin Name: Table Builder for CSV
Plugin URI: https://github.com/mostafa272/Table-Builder-for-CSV
Description: The Table Builder for CSV is a simple plugin that creates HTML table from csv file.
Version: 1.0
Author: Mostafa Shahiri<mostafa2134@gmail.com>
Author URI: https://github.com/mostafa272
*/
/*  Copyright 2009  Mostafa Shahiri(email : mostafa2134@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_action( 'wp_enqueue_scripts', 'tbfs_table_builder_for_CSV_scripts' );
/**
 * Add our JS and CSS files
 */
function tbfs_table_builder_for_CSV_scripts() {
  wp_register_script( 'tablebuilderforcsv-script', plugins_url( 'js/script.js', __FILE__ ),array('jquery'),'1.0',false );
        wp_register_style( 'tablebuilderforcsv-style', plugins_url( 'css/style.css', __FILE__ ) );

}

//callback function of shortcode
function tbfs_table_builder_for_csv_makeshortcode($atts) {
//get attributes for shortcode
wp_enqueue_script('tablebuilderforcsv-script');
wp_enqueue_style('tablebuilderforcsv-style');
$a = shortcode_atts( array('src' => '', 'id'=>'1','captions'=>'','searchbox' => 'false','rows'=>'10', 'textalign'=>'center','headerbg'=>'#FF0000', 'headercolor'=>'#FFF','pagebg'=>'#FF0000', 'pagecolor'=>'#FFF','pageactive'=>'#008000','pagehoverbg'=>'#CCC','pagehovercolor'=>'#000','pagealign'=>'center'), $atts );
$up_dir=wp_upload_dir();
$fileurl=trailingslashit($up_dir['basedir']).sanitize_text_field($a['src']);
$filepath=wp_check_filetype($fileurl);
$a['id']=sanitize_text_field($a['id']);
$a['captions']=sanitize_text_field($a['captions']);
$a['searchbox']=sanitize_text_field($a['searchbox']);
$a['rows']=intval($a['rows']);
//set inline js and css values
$list=array();
$list['textalign']=sanitize_text_field($a['textalign']);
$list['headerbg']=sanitize_text_field($a['headerbg']);
$list['headercolor']=sanitize_text_field($a['headercolor']);
$list['pagebg']=sanitize_text_field($a['pagebg']);
$list['pagecolor']=sanitize_text_field($a['pagecolor']);
$list['pageactive']=sanitize_text_field($a['pageactive']);
$list['pagehoverbg']=sanitize_text_field($a['pagehoverbg']);
$list['pagehovercolor']=sanitize_text_field($a['pagehovercolor']);
$list['pagealign']=sanitize_text_field($a['pagealign']);
//add inline js and css code to footer
 if(!empty($a['captions']))
 {
 $caption=explode('@#',$a['captions']);
 }

 ob_start();
if($filepath['type']=='text/csv')
 {
  $file = fopen($fileurl,"r");
  echo '<div class="tblbuildercsv" style="display:none;" data-name="'.$a['id'].'" data-rows="'.$a['rows'].'" data-textalign="'.$list['textalign'].'" data-headerbg="'.$list['headerbg'].'" data-headercolor="'.$list['headercolor'].'" data-pagebg="'.$list['pagebg'].'" data-pagecolor="'.$list['pagecolor'].'" data-pageactive="'.$list['pageactive'].'" data-pagehoverbg="'.$list['pagehoverbg'].'" data-pagehovercolor="'.$list['pagehovercolor'].'" data-pagealign="'.$list['pagealign'].'"></div>';
 if($a['searchbox']=='true')
 echo "<input type=\"text\" id=\"csvlookup".$a['id']."\" class=\"csvlookup\" onkeyup=\"lookuptable(".$a['id'].",".$a['rows'].")\" placeholder=\"Search for ...\"><br>";
 echo '<table class="csvtable" id="csvtable'.$a['id'].'">';
 //use custom captions
 if(!empty($a['captions']))
 {
  echo '<tr>';
   for($i=0;$i<count($caption);$i++)
  {
   echo '<td>'.$caption[$i].'</td>';
  }
   echo '</tr>';

 }
//read csv file
while($f=fgetcsv($file))
{
//displaying rows
echo '<tr>';
for($i=0;$i<count($f);$i++)
{
   echo '<td>'.$f[$i].'</td>';
}
echo '</tr>';
}
echo '</table>';
 echo	'<div id="csvpagination'.$a['id'].'" class="csvpagination"></div>';
fclose($file);
}
 return ob_get_clean();
}
//add shortcode
add_shortcode('table_builder_for_csv','tbfs_table_builder_for_csv_makeshortcode');