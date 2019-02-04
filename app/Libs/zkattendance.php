<?php
    function getSizeAttendance($self) {
        /*Checks a returned packet to see if it returned CMD_PREPARE_DATA,
        indicating that data packets are to be sent

        Returns the amount of bytes that are going to be sent*/
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $self->data_recv, 0, 8 ) ); 
        $command = hexdec( $u['h2'].$u['h1'] );
        
        if ( $command == CMD_PREPARE_DATA ) {
            $u = unpack('H2h1/H2h2/H2h3/H2h4', substr( $self->data_recv, 8, 4 ) );
            $size = hexdec($u['h4'].$u['h3'].$u['h2'].$u['h1']);
            return $size;
        } else
            return FALSE;
    }
    
    if ( function_exists('reverseHex') ) {
        function reverseHex($hexstr) {
            $tmp = '';
            
            for ( $i=strlen($hexstr); $i>=0; $i-- ) {
                $tmp .= substr($hexstr, $i, 2);
                $i--;
            }
            
            return $tmp;
        }
    }

    function zkgetattendance($self) {
        $command = CMD_ATTLOG_RRQ;
        $command_string = '';
        $chksum = 0;
        $session_id = $self->session_id;
        
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $self->data_recv, 0, 8) );
        $reply_id = hexdec( $u['h8'].$u['h7'] );

        $buf = $self->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
        
        socket_sendto($self->zkclient, $buf, strlen($buf), 0, $self->ip, $self->port);
        
        //try {
        socket_recvfrom($self->zkclient, $self->data_recv, 1024, 0, $self->ip, $self->port);
        
        if ( getSizeAttendance($self) ) {
            $bytes = getSizeAttendance($self);
            while ( $bytes > 0 ) {
                socket_recvfrom($self->zkclient, $data_recv, 1032, 0, $self->ip, $self->port);
                array_push( $self->attendancedata, $data_recv);
                $bytes -= 1024;
            }
            
            $self->session_id =  hexdec( $u['h6'].$u['h5'] );
            socket_recvfrom($self->zkclient, $data_recv, 1024, 0, $self->ip, $self->port);
        }
        
        $attendance = array();  
        if ( count($self->attendancedata) > 0 ) {
            # The first 4 bytes don't seem to be related to the user
            for ( $x=0; $x<count($self->attendancedata); $x++) {
                if ( $x > 0 )
                    $self->attendancedata[$x] = substr( $self->attendancedata[$x], 8 );
            }
            
            $attendancedata = implode( '', $self->attendancedata );
            $attendancedata = substr( $attendancedata, 10 );
            
            while ( strlen($attendancedata) > 40 ) {
                
                $u = unpack( 'H78', substr( $attendancedata, 0, 39 ) );
                //24s1s4s11s
                //print_r($u);

                $u1 = hexdec(substr($u[1], 4, 2));
					$u2 = hexdec(substr($u[1], 6, 2));
					$uid = $u1+($u2*256);
					$id = str_replace("\0", '', hex2bin(substr($u[1], 8, 16)));
                $state = hexdec( substr( $u[1], 66, 2 ) );
                $timestamp = decode_time( hexdec( reverseHex( substr($u[1], 58, 8) ) ) ); 
				
                # Clean up some messy characters from the user name
                #uid = unicode(uid.strip('\x00|\x01\x10x'), errors='ignore')
                #uid = uid.split('\x00', 1)[0]
                #print "%s, %s, %s" % (uid, state, decode_time( int( reverseHex( timestamp.encode('hex') ), 16 ) ) )
                
                array_push( $attendance, array( $uid, $id, $state, $timestamp ) );
                
                $attendancedata = substr( $attendancedata, 40 );
            }
            
        }
            
        return $attendance;
        //} catch(exception $e) {
            //return False;
        //}
    }
    
    function getAttendance() 
	{
		$command = CMD_ATTLOG_RRQ;
		$command_string = '';
		$chksum = 0;
		$session_id = $this->session_id;
		$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, 0, 8));
		$reply_id = hexdec($u['h8'].$u['h7']);
		$buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
		socket_sendto($this->socket, $buf, strlen($buf), 0, $this->ip, $this->port);
		try 
		{
			socket_recvfrom($this->socket, $this->received_data, 1024, 0, $this->ip, $this->port);
			$bytes = $this->getSizeAttendance();
			if($bytes) 
			{
				while($bytes > 0) 
				{
					socket_recvfrom($this->socket, $received_data, 1032, 0, $this->ip, $this->port);
					array_push($this->attendance_data, $received_data);
					$bytes -= 1024;
				}
				$this->session_id = hexdec($u['h6'].$u['h5']);
				socket_recvfrom($this->socket, $received_data, 1024, 0, $this->ip, $this->port);
			}
			$attendance = array();  
			if(count($this->attendance_data) > 0)
			{
				for($x=0; $x<count($this->attendance_data); $x++)
				{
					if($x > 0)
					{
						$this->attendance_data[$x] = substr($this->attendance_data[$x], 8);
					}
				}
				$attendance_data = implode('', $this->attendance_data);
				$attendance_data = substr($attendance_data, 10);
				while(strlen($attendance_data) > 40) 
				{
					$u = unpack('H78', substr($attendance_data, 0, 39));
					$u1 = hexdec( substr($u[1], 4, 2) );
					$u2 = hexdec( substr($u[1], 6, 2) );
					$uid = $u1+($u2*256);																//ID DEL USUARIO
					$id = str_replace("\0", '', hex2bin(substr($u[1], 8, 16)));
					//$userid = hex2bin(substr($u[1], 98, 72)).' ';      // 36 byte
					//$useridArr = explode(chr(0), $userid, 2);           // explode to array
					//$userid = $useridArr[0];                            // get user ID
					//var_dump($u);
					$state = hexdec( substr( $u[1], 66, 2 ) );
					//$state = hexdec(substr( $u[1], 56, 2 ) );
					$timestamp = $this->decodeTime(hexdec($this->reverseHex(substr($u[1], 58, 8)))); 
					array_push($attendance, array($uid, $id, $state, $timestamp));
					$attendance_data = substr($attendance_data, 40 );
				}
			}
			return $attendance;
		} 
		catch(exception $e) 
		{
			return false;
		}
	}
    
    /*function zkclearattendance($self) {
        $command = CMD_CLEAR_ATTLOG;
        $command_string = '';
        $chksum = 0;
        $session_id = $self->session_id;
        
        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $self->data_recv, 0, 8) );
        $reply_id = hexdec( $u['h8'].$u['h7'] );

        $buf = $self->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
        
        socket_sendto($self->zkclient, $buf, strlen($buf), 0, $self->ip, $self->port);
        
        try {
            @socket_recvfrom($self->zkclient, $self->data_recv, 1024, 0, $self->ip, $self->port);
            
            $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr( $self->data_recv, 0, 8 ) );
            
            $self->session_id =  hexdec( $u['h6'].$u['h5'] );
            return substr( $self->data_recv, 8 );
        } catch(exception $e) {
            return False;
        }
    }*/
?>
