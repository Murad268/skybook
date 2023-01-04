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

    $a = array( 365 * 24 * 60 * 60  =>  'il',
                 30 * 24 * 60 * 60  =>  'ay',
                      24 * 60 * 60  =>  'gün',
                           60 * 60  =>  'saat',
                                60  =>  'dəqiqə',
                                 1  =>  'saniyə'
                );
    $a_plural = array( 'year'   => 'il',
                       'ay'  => 'ay',
                       'gün'    => 'gün',
                       'saat'   => 'saat',
                       'dəqiqə' => 'dəqiqə',
                       'saniyə' => 'saniyə'
                     //   əgər ingiliscəyə çevirmək lazım olsa
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' əvvəl';
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
      $user_avatar = $users["avatar"];
   }
?>