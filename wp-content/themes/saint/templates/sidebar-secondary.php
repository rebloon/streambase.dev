<?php
/****************************/
/**** Sidebar Secondary  ****/ 
/****************************/

// -- Get the sidebar for this page/section --
$sidebar = ac_get_right_sidebar();
dynamic_sidebar($sidebar);