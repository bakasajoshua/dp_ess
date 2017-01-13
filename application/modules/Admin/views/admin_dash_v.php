<main>
    <div class="row">
        <div class="col-sm-12">
            <div class="ess-panel">
                <div class="ess-panel-header">
                    <h2>Email Management</h2>
                </div>

                <div class="ess-panel">
                    <div class="ess-panel-body">
                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Page Used</th>
                                    <th>Subject</th>
                                    <th>Email Content</th>
                                    <th>Email Footer</th>
                                    <th>Reason For Sending</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php

                                    $emailTemplates = json_decode($emailTemplates);

                                    $i=0;
                                    foreach ($emailTemplates as $key => $value) {
                                        $row = "";
                                        $i++;
                                        $value = (array)$value;
                                        
                                        
                                        $emailID = $value['emailID'];
                                        $pageUsed = $value['pageUsedAt'];
                                        $subject = $value['subject'];
                                        $emailContent = $value['emailContent'];
                                        $emailFooter = $value['emailFooter'];
                                        $reason = $value['reasonForSending'];
                                        $row = '<tr data-toggle="modal" data-target="#myModal" style="cursor:pointer;" onclick="getEmailID('.$emailID.')">';
                                        $row .= '<td>'.($i).'</td>' ;
                                        $row .= '<td class="pageUsedAt">'.$pageUsed.'</td>';
                                        $row .= '<td class="emailSubject">'.$subject.'</td>';
                                        $emailContent = str_replace('"',"",$emailContent);
                                        $row .= '<td class="emailContent">'.$emailContent.'</td>';
                                        $row .= '<td class="emailFooter">'.$emailFooter.'</td>';
                                        $row .= '<td class="reasonForSending">'.$reason.'</td>';
                                        $row .= '</tr>';
                                        echo $row;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Action</h4>
                            </div>
                            <div class="modal-body">
                                <center>
                                    <p id="error" style="padding: 5% 0% 0% 0%; display: none;"><em>Error:</em> The Username or Password is incorrect.</p>
                                </center>
                                <div class="ess-panel-body">
                                    <div class="form-group ess-textbox-ul-left-label">
                                        <center>
                                            <label class="col-sm-3">Subject:</label>
                                            <p id="emailSubjectModal"></p>
                                            
                                            <label class="col-sm-3">Email Footer:</label> 
                                            <p id="emailFooterModal"></p>

                                            <label class="col-sm-3">Reason For Sending</label>
                                            <p id="reasonForSendingModal"></p>
                                            
                                            <label class="col-sm-6" for="example_textbox4">Email Body:</label>
                                            <p id="emailContentModal"></p>
                                        </center>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- <button class="btn btn-success ess-button" type="submit">Respond</button> -->
                                <div class="ess-positive-negative-button-pair success">
                                    <div>
                                        <button class="btn btn-success" style="width: 100px" type="submit">
                                            Approve
                                        </button>
                                        <button class="btn btn-success"  style="width: 100px" type="submit">
                                            Deny
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                </div>
            </div>
        </div>
    </div>
</main>
