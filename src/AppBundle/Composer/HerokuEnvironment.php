<?php
namespace AppBundle\Composer;
 
use Composer\Script\Event;
 
class HerokuEnvironment
{
    /**
     * Populate Heroku environment
     *
     * @param Event $event Event
     */
    public static function populateEnvironment(Event $event)
    {
        //$url = getenv('CLEARDB_DATABASE_URL'); // If MySQL is chosen
        $url = getenv('DATABASE_URL'); //If PostgreSQL is chosen
 
        if ($url) {
            $url = parse_url($url);
            putenv("DATABASE_HOST={$url['host']}");
            putenv("DATABASE_USER={$url['user']}");
            putenv("DATABASE_PASSWORD={$url['pass']}");
 
            $db = substr($url['path'], 1);
            putenv("DATABASE_NAME={$db}");
        }
 
        $io = $event->getIO();
        $io->write("DATABASE_URL=".getenv("DATABASE_URL"));
    }    
}