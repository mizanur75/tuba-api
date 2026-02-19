<?php


if (!function_exists('multi_errors')) {
	function multi_errors($errors){
		$html = '';
		if($errors->any()){
            foreach($errors->all() as $error){
	            $html .='<div class="col-md-12">';
	            $html .=     '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
	            $html .=         '<strong>'. $error .'</strong>';
	            $html .=         '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
	            $html .=             '<span aria-hidden="true">×</span>';
	            $html .=         '</button>';
	            $html .=     '</div>';
	            $html .= '</div>';
            }
		}
        return $html;
	}
}



if (!function_exists('success')) {
	function success(){
		$html = '';
		if(Session::has('success')){
            $html .='<div class="col-md-12">';
            $html .=     '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            $html .=         '<strong>'. Session::get('success') .'</strong>';
            $html .=         '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $html .=             '<span aria-hidden="true">×</span>';
            $html .=         '</button>';
            $html .=     '</div>';
            $html .= '</div>';
		}
        return $html;	
	}
}