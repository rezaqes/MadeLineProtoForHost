<?php

/** owghat(month,day,longitude,latitude,Show_seconds,Daylight_Saving_Time_On,farsi_numbers) // Version:1.1 _ http://123.scr.ir */

function owghat($m,$d,$lg,$lat,$seconds=1,$dslst=1,$farsi=1){
 $a_2=array(107.695,90.833,0,90.833,94.5,0);
 $doy_1=(($m<7)?($m-1):6) + (($m-1)*30) + $d;
 for($h=0,$i=0;$i<6;$i++){
  $s_m=$m;$s_lg=$lg;  
  if($i<5){
   $doy=$doy_1+($h/24);
	$s_m=74.2023+(0.98560026*$doy);
	$s_l=-2.75043+(0.98564735*$doy);
	$s_lst=8.3162159+(0.065709824*floor($doy))+(24.06570984*fmod($doy,1))+($s_lg/15);	
	$s_omega=(4.85131-(0.052954*$doy))*0.0174532;
	$s_ep=(23.4384717+(0.00256*cos($s_omega)))*0.0174532;
	$s_u=$s_m;
	for($s_i=1;$s_i<5;$s_i++){
	 $s_u=$s_u-(($s_u-$s_m-(0.95721*sin(0.0174532*$s_u)))/(1-(0.0167065*cos(0.0174532*$s_u))));
	}
	$s_v=2*(atan(tan(0.00872664*$s_u)*1.0168)*57.2957);
	$s_theta=($s_v-$s_m-2.75612-(0.00479*sin($s_omega))+(0.98564735*$doy))*0.0174532;
	$s_delta=asin(sin($s_ep)*sin($s_theta))*57.2957;
	$s_alpha=57.2957*atan2(cos($s_ep)*sin($s_theta),cos($s_theta));
	if($s_alpha>=360)$s_alpha-=360;
	$s_ha=$s_lst-($s_alpha/15);
	$s_zohr=fmod($h-$s_ha,24);
   $loc2hor=((acos(((cos(0.0174532*$a_2[$i])-sin(0.0174532*$s_delta)*sin(0.0174532*$lat))/cos(0.0174532*$s_delta)/cos(0.0174532*$lat)))*57.2957)/15);
   $azan[$i]=fmod((($i<2)?($s_zohr-$loc2hor):(($i>2)?$s_zohr+$loc2hor:$s_zohr)),24);
  }else{
   $azan[$i]=($azan[0]+$azan[3]+24)/2;
  }
   $x=$azan[$i];
	if($dslst==1 and $doy_1>1 and $doy_1<186){$x++;}else{$dslst=0;}
	if($x<0){$x+=24;}elseif($x>=24){$x-=24;}
	$hor=(int)($x);
	$ml=fmod($x,1)*60;
	$min=(int)($ml);
	$mr=round($ml);
	if($mr==60){$mr=0;$hor++;}
	$sec=(int)(fmod($ml,1)*60);
	$a_1[$i]=(($hor<10)?'0':'').$hor.':'.( ($seconds==0) ? ((($mr<10)?'0':'').$mr) : ((($min<10)?'0':'').$min.':'.(($sec<10)?'0':'').$sec) );
	if($h==0){$h=$azan[$i];$i--;}else{$h=0;}
 }
 $out=array(
	's'=>$a_1[0],
	't'=>$a_1[1],
	'z'=>$a_1[2],
	'g'=>$a_1[3],
	'm'=>$a_1[4],
	'n'=>$a_1[5],
	'month'=>$m,
	'day'=>$d,
	'longitude'=>$lg,
	'latitude'=>$lat,
	'show_seconds'=>$seconds,
	'daylight_saving_time'=>$dslst,
	'farsi_numbers'=>$farsi
 );
 if($farsi==1)$out=str_replace(array('0','1','2','3','4','5','6','7','8','9','.'),array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٫'),$out);
 return $out;
}
?>