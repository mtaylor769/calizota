<?php
$minimumversion = "5.3.0";
$minimummysqlversion = "3.23.58";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Current Server Configuration</title>
<style type="text/css">
<!--
.passed {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #009933;
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
	text-align: right;
}
.failed {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	text-transform: capitalize;
	color: #CC0000;
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
	text-align: right;
}
.label {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #333333;
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #CCCCCC;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
	border-left-color: #CCCCCC;
}
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
a:link {
	color: #666666;
}
a:visited {
	color: #666666;
}
a:hover {
	color: #333333;
}
a:active {
	color: #666666;
}
.style3 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
</head>
<body>
<table width="929" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="84%">&nbsp;</td>
            <td width="16%">&nbsp;</td>
          </tr>
          <tr>
            <td height="41" class="tableheadingbg"><span class="style1">WP EasyCart Server Checklist </span><span class="style2">- v3.0</span></td>
            <td height="41" class="style2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" class="productheading style2">This utility will check common server settings, PHP information, extensions loaded, file and folder read/write tests. If you have a failed component, it is best to simply show this page to your web hosting provider and they will make alterations so that they pass.</td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: Version Minimum (<?php echo $minimumversion ?>) - Currently <?php echo phpversion() ?> &nbsp;&nbsp;&nbsp;</td>
            <?php
                        	// ======= Version Check =======
                            $phpversionresult = version_compare(phpversion(), $minimumversion);
                            
                            if ($phpversionresult == -1)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: File_Uploads Enabled</td>
            <?php
                        	// ======= File Uploads =======
							if (ini_get("file_uploads") != "1")
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: openSSL extension Enabled</td>
            <?php
							// ======= openSSL =======
							$isopenssl = extension_loaded("openssl");
							if (!$isopenssl)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: CURL extension Enabled</td>
            <?php
                        	// ======= Curl =======
							$iscurl = extension_loaded("curl");
							if (!$iscurl)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: GD Image extension Enabled</td>
            <?php
                        	// ======= GD =======
							$isgd = extension_loaded("gd");
							if (!$isgd)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: SOAP extension Enabled</td>
            <?php
                        	// ======= SOAP =======
							$isSOAP = extension_loaded("SOAP");
							if (!$isSOAP)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: MySQL extension Enabled</td>
            <?php
                        	// ======= MySQL =======
							$isMySQL = extension_loaded("MySQL");
							if (!$isMySQL)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: MySQLi extension Enabled</td>
            <?php
                        	// ======= MySQL =======
							$isMySQL = extension_loaded("MySQLi");
							if (!$isMySQL)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP: XMLRPC extension Enabled </td>
            <?php
                        	// ======= XMLRPC =======
							$isXMLRPC = extension_loaded("XMLRPC");
							if (!$isXMLRPC)
                            {
                               echo "<td class='failed'>Failed</td>"; 
                            } else {
                                echo "<td class='passed'>Passed</td>";
                            }
						?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Maximum Upload File Size (php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= Upload Max Size =======
							echo ini_get("upload_max_filesize");
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Maximum Execution Time(php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= max_execution_time =======
							echo ini_get("max_execution_time");
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Maximum Input Time (php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= max_input_time =======
							echo ini_get("max_input_time");
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Memory Limit (php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= memory_limit =======
							echo ini_get("memory_limit");
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Post Max Size (php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= post_max_size =======
							echo ini_get("post_max_size");
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Output Buffering (php.ini setting)</td>
            <td class='passed'><?php
                        	// ======= output_buffering =======
							if (ini_get("output_buffering") == 1) echo 'ON';
							if (ini_get("output_buffering") == 0) echo 'OFF';
					
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">oAuth for PHP Installed</td>
            <td class='passed'><?php
                        	// ======= output_buffering =======
							if( !class_exists( 'OAuth' ) ) echo 'No';
							if( class_exists( 'OAuth' ) ) echo 'Yes';
					
						?></td>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Testing PHP mkdir() 0777 to /wp-content/plugins/ directory</td>
            <?php 
			
			$to = dirname( __FILE__ ) . "/../../../testfolder/";
			$success = mkdir( $to, 0777 );
			if( !$success ){
				echo "<td class='failed'>Failed</td>"; 
			} else {
				echo "<td class='passed'>Passed</td>";
			}

		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Testing PHP rmdir() to /wp-content/plugins/ directory</td>
            <?php 
			if ($success) {
				$to = dirname( __FILE__ ) . "/../../../testfolder/";
				$remove = rmdir( $to );
				if( !$remove ){
					echo "<td class='failed'>Failed</td>"; 
				} else {
					echo "<td class='passed'>Passed</td>";
				}
			} else {
				echo "<td class='failed'>Failed</td>"; 	
			}

		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Testing write File to /wp-content/plugins/ directory</td>
            <?php
			
			$ec_test_php = 'test file write'; 
		
			$ec_test_filename = dirname( __FILE__ ) . "/../../../testfile.php";
			$ec_test_filehandler = fopen($ec_test_filename, 'w');
			if(!$ec_test_filehandler) {
				echo "<td class='failed'>fopen Failed</td>"; 
			} else {
				if(!fwrite($ec_test_filehandler, $ec_test_php)) {
					echo "<td class='failed'>fwrite Failed</td>"; 
				} else {
					if(!fclose($ec_test_filehandler)) {
						echo "<td class='failed'>fclose Failed</td>";
						unlink($ec_test_filename);
					} else {
						echo "<td class='passed'>Passed</td>";
						unlink($ec_test_filename);
					}
				}
			}
		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Testing write File to EasyCart plugin root directory</td>
            <?php
			
			$ec_test_php = 'test file write'; 
		
			$ec_test_filename = dirname( __FILE__ ) . "/../../testfile.php";
			$ec_test_filehandler = fopen($ec_test_filename, 'w');
			if(!$ec_test_filehandler) {
				echo "<td class='failed'>fopen Failed</td>"; 
			} else {
				if(!fwrite($ec_test_filehandler, $ec_test_php)) {
					echo "<td class='failed'>fwrite Failed</td>"; 
				} else {
					if(!fclose($ec_test_filehandler)) {
						echo "<td class='failed'>fclose Failed</td>";
						unlink($ec_test_filename);
					} else {
						echo "<td class='passed'>Passed</td>";
						unlink($ec_test_filename);
					}
				}
			}
		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">Session Test (should increment by 1 with refresh)</td>
            <?php
			session_start();
			$_SESSION['test'] += 1;
			
			if(isset($_SESSION['test'])) {
				echo "<td class='passed'>" . $_SESSION['test'] . "</td>";
			}
		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">PHP Session Path</td>
            <?php
			
			if(session_save_path()) {
				echo "<td  class='passed'>" . session_save_path() . "</td>";
			} else {
				echo "<td class='failed'>No Session Path</td>";
			}
			
		?>
          </tr>
          <tr>
            <td class="productheading">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>