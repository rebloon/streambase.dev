<?php
/**************************/
/**** Sidebar Primary  ****/ 
/**************************/

// -- Get the sidebar for this page/section --
$sidebar = ac_get_left_sidebar();
dynamic_sidebar($sidebar);