<?php
   include('connect.php');
function minseo ($variable) {
   return htmlspecialchars(trim($variable));
} 
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
function createActivationCode() {
   $rand = sha1(mt_rand(10000,99999).time());
   return $rand;
}
function donusumleriGeriDondur($deger) {
   $geriDondur = htmlspecialchars_decode($deger, ENT_QUOTES);
   return $geriDondur;
}
   if(isset($_SESSION["email"])) {
      $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ?");
      $searchUser->execute([$_SESSION["email"]]);
      $users = $searchUser->fetch(PDO::FETCH_ASSOC);
      $user_email = $users["user_email"];
      $user_login = $users["user_login"];
      $user_id = $users["id"];
   }
?>