<html>
	<head>

	</head>
	<body>
		<center>
		    <table style="width:100%">
		        <tbody><tr>
		            <td align="center" valign="top">
		                <table style="width:800px!important">
		                    <tbody>
		                    <tr class="m_5968099222314295585spaceUnder">
		                        <td align="center" background="https://ci6.googleusercontent.com/proxy/GplPP2ECtixLRlNJVLkIzW_4ybAMZQlIjZMVsNZkaaByR8M1O3Bm7Oa4zddAjmSB2MHGkW9kYcmGOB14Iuw7SRRBrbVUAemODU55CSBRmrQhoFyKp7MGUK5H4J3tK5DjDGQfCw7wDjOyhtgjLcqGcs1VvUFo0uXLuao=s0-d-e1-ft#http://flaelbuat01-588519708.ap-southeast-1.elb.amazonaws.com/billerDashboard/public/images/Body-BG.jpg" class="m_5968099222314295585base">
		                            <table class="m_5968099222314295585zigzag-top">
		                                <tbody>
		                                	<tr>
		                                    	<td align="center" colspan="2">&nbsp;</td>
		                                	</tr>
		                            </tbody></table>
		                            <table style='width: 50%;'>
		                                <tbody><tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>

		                                <tr>
		                                    <td align="center" colspan="2"><!-- <hr style='border-color: #fff;border: 0px; border-top: 1px solid aliceblue;'> --></td>
		                                </tr>
		                            </tbody></table>
		                            <table class="" style='background: #fff; width: 70%; border-radius: 10px; box-shadow: 0px 5px 5px #2f83ac;'>
		                                <tbody><tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>
		                                
		                                <tr>
		                                    <td align="center" colspan="2" valign="baseline">
		                                        <!-- <h2 style="margin-top: 0px;margin-bottom: 10px; font-size:30px;">Quotation</h2> -->
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>
                                            <tr>
		                                        <td style="width:40%;padding-left:10%">
		                                            <span class="">Type </span>
		                                        </td>
		                                        <td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
		                                            <span class=""><?php echo $type; ?></span>
		                                        </td>
		                                    </tr>
		                                	<tr>
		                                        <td style="width:40%;padding-left:10%">
		                                            <span class="">Date</span>
		                                        </td>
		                                        <td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
		                                            <span class=""><?php echo $thedate; ?></span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width:40%;padding-left:10%">
		                                            <span class="">From</span>
		                                        </td>
		                                        <td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
                                                <span class=""><?php echo $fromname; ?></span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width:40%;padding-left:10%">
		                                            <span class="">Reference</span>
		                                        </td>
		                                        <td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
                                                    <span class=""><?php echo $reference; ?></span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width:40%;padding-left:10%">
		                                            <span class="">Message</span>
		                                        </td>
		                                        <td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
                                                    <span class=""><?php echo htmlspecialchars_decode(stripslashes($msg)); ?></span>
		                                        </td>
		                                    </tr>

											<?php if(isset($link)) { ?>
												<tr>
													<td style="width:40%;padding-left:10%">
														<span class="">opt out notification</span>
													</td>
													<td style="width:60%;padding:2% 5% 2% 5%; font-weight: bold; font-size: 18px; color: #4b4b4b;">
														<span class=""><a href='<?php echo $link; ?>'> deactivate notification </a></span>
													</td>
												</tr>
											<?php } ?>

		                                    <tr>
		                                        <td align="center" colspan="2">&nbsp;</td>
		                                    </tr>
		                                    <tr>
		                                        <td align="center" colspan="2">&nbsp;</td>
		                                    </tr>
		                                    <tr>
		                                        <td align="center" colspan="2">&nbsp;</td>
		                                    </tr>
		                                    <tr>
		                                        <td align="center" colspan="2"> 
                                                    <a href="<?php echo $redirect; ?>" style="background: #3673ec;border: none;border-radius: 4px;padding: 3% 15%;font-size: 14px;color: #fff;"> View </a> 
                                                </td>
		                                    </tr>
		                                    <tr>
		                                        <td align="center" colspan="2">&nbsp;</td>
		                                    </tr>
		                                    <tr>
		                                    	<td align="center" colspan="2">&nbsp;</td>
		                                	</tr>
		                                <tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>
		                                <tr>
		                                	<td align="center" valign="baseline" colspan="2">
                                            <img src="https://webapp.dimensionsystems.com/assets/media/logos/DimensionSystems-logo-r1.png" style="max-width:250px" class="CToWUd" data-bit="iit">
		                                    <br>
		                                    <span class="m_5968099222314295585paybills">DSI WebApp</span>
		                                </td>
		                                </tr><tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>
		                                <tr>
		                                    <td align="center" colspan="2">&nbsp;</td>
		                                </tr>
		                            </tbody></table>
		                            <table style='width:50%;'>
		                                <tbody>
		                                <tr>
		                                    <td align="center" colspan="2"><hr style='border-color: #fff;border: 0px; border-top: 1px solid aliceblue;'></td>
		                                </tr>
		                            </tbody></table>
		                            <br><br>
		                        </td>
		                    </tr>
		                </tbody>
		            	</table>
		            </td>
		        </tr>
		    </tbody></table>
		</center>
	</body>
</html>