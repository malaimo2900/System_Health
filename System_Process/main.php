<?php

// socket based chat

require __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);

$conns = new \SplObjectStorage();

$socket->on('connection', function ($conn) use ($conns) {
    $conns->attach($conn);
	
    $conn->on('data', function ($data) use ($conns, $conn) {
        foreach ($conns as $current) {
            if ($conn === $current) {
                continue;
            }
			
			/// Do REST CALL
			
            $current->write($conn->getRemoteAddress().': ');
            $current->write($data);
        }
    });
	
    $conn->on('end', function () use ($conns, $conn) {
        $conns->detach($conn);
    });
});


$socket->listen(4000);

$i = -1;
$loop->addPeriodicTimer(2, function ($timer) {
	global $i;
	$i++;
    /// check children processes
    echo "check children processes\n";
    /// if one has not started or died, start it 
    if ($i < 2) {
    	$pid = pcntl_fork();
	} else {
		$timer->cancel();
		return 0;
	}
	if ($pid == -1) {
    	die('could not fork');
	} else if ($pid) {
		echo "PARENT: $i\n";
	} else {
		switch($i) {
			case 0:
			case 1:
	     		pcntl_exec('./test.php', array($i));
				break;
			default:
				echo "EXIT\n";
				posix_kill(posix_getpid(), SIGTERM);
				break;
		}
	}
	echo "HERE\n";
});

$loop->addPeriodicTimer(2, function ($timer) {
	echo "HI\n".posix_getpid()."\n";
});

$loop->run();