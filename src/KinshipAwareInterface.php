<?php
namespace phamily\framework;

interface KinshipAwareInterface{
					//ZYXWVUTSRQPONMLKJIHGFEDCBA	
	const FATHER 				= 0x000000000001;
	const MOTHER 				= 0x000000000010;
	const PARENTS 				= 0x000000000011;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA
	const SON					= 0x000000000100;
	const DAUGHTER				= 0x000000001000;
	const CHILDREN 				= 0x000000001100;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA
	const HUSBAND 				= 0x000000010000;
	const WIFE 					= 0x000000100000;
	const SPOUSES 				= 0x000000110000;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA	
	const BROTHER				= 0x000001000000;
	const SISTER				= 0x000010000000;
	const SIBLINGS				= 0x000011000000;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA	
	const HALF_BROTHER_PATERNAL	= 0x000100000000;
	const HALF_SISTER_PATERNAL	= 0x001000000000;
	const HALF_SIBLING_PATERNAL	= 0x001100000000;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA
	const HALF_BROTHER_MATERNAL	= 0x010000000000;
	const HALF_SISTER_MATERNAL	= 0x100000000000;
	const HALF_SIBLING_MATERNAL	= 0x110000000000;
	
	const HALF_SIBLING			= 0x111100010000;
					//ZYXWVUTSRQPONMLKJIHGFEDCBA	
}