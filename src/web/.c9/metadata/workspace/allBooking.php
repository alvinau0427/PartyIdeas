{"filter":false,"title":"allBooking.php","tooltip":"/allBooking.php","undoManager":{"mark":3,"position":3,"stack":[[{"start":{"row":20,"column":22},"end":{"row":20,"column":23},"action":"remove","lines":["6"],"id":2}],[{"start":{"row":20,"column":22},"end":{"row":20,"column":23},"action":"insert","lines":["1"],"id":3}],[{"start":{"row":20,"column":23},"end":{"row":20,"column":24},"action":"insert","lines":["2"],"id":4}],[{"start":{"row":479,"column":5},"end":{"row":677,"column":20},"action":"remove","lines":["<div class=\"span6\"> <!-------------------------------------------------------- right ---------------------------------------------------->","\t\t\t\t\t","\t\t\t\t\t<?php","              if(!isset($_SESSION['type'])){ //--------------------------------- customer -------------------------------------","\t\t\t\t\t  ?>","\t\t\t\t\t  ","\t\t\t\t\t  ","\t\t\t\t\t\t","\t\t\t\t\t\t","\t\t\t\t\t\t","\t\t\t\t\t\t","\t\t\t\t\t\t","\t\t\t\t\t\t","\t\t\t\t\t\t<?php","              }","              if($_SESSION['type'] == 'customer'){ //--------------------------------- customer -------------------------------------","\t\t\t\t\t  ?>","\t\t\t\t\t\t","\t\t\t\t\t\t<div class=\"widget\">","\t\t\t\t\t\t\t<div class=\"widget-header\"> <i class=\"icon-bookmark\"></i>","\t\t\t\t\t\t\t\t<h3>Search Flight</h3>","\t\t\t\t\t\t\t</div>","\t\t\t\t\t\t\t<!-- /widget-header -->","\t\t\t\t\t\t\t<div class=\"widget-content\">","\t\t\t\t\t\t\t\t<form id=\"edit-profile\" class=\"form-horizontal\">","\t\t\t\t\t\t\t\t\t<fieldset>","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"username\">Username</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"text\" class=\"span4 disabled\" id=\"username\" value=\"Example\" disabled>","\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"help-block\">Your username is for logging in and cannot be changed.</p>","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"firstname\">First Name</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"text\" class=\"span4\" id=\"firstname\" value=\"John\">","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"lastname\">Last Name</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"text\" class=\"span4\" id=\"lastname\" value=\"Donga\">","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"email\">Email Address</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"text\" class=\"span4\" id=\"email\" value=\"john.donga@egrappler.com\">","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<br /><br />","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"password1\">Password</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"password\" class=\"span4\" id=\"password1\" value=\"thisispassword\">","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"password2\">Confirm</label>","\t\t\t\t\t\t\t\t\t\t\t<div class=\"controls\">","\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"password\" class=\"span4\" id=\"password2\" value=\"thisispassword\">","\t\t\t\t\t\t\t\t\t\t\t</div> <!-- /controls -->\t\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","\t\t\t\t\t\t\t\t\t\t","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\">Checkboxes</label>","\t\t\t\t\t\t\t\t\t\t\t","                                            ","                                            <div class=\"controls\">","                                            <label class=\"checkbox inline\">","                                              <input type=\"checkbox\"> Option 01","                                            </label>","                                            ","                                            <label class=\"checkbox inline\">","                                              <input type=\"checkbox\"> Option 02","                                            </label>","                                          </div>\t\t<!-- /controls -->\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\">Radio Buttons</label>","\t\t\t\t\t\t\t\t\t\t\t","                                            ","                                            <div class=\"controls\">","                                            <label class=\"radio inline\">","                                              <input type=\"radio\"  name=\"radiobtns\"> Option 01","                                            </label>","                                            ","                                            <label class=\"radio inline\">","                                              <input type=\"radio\" name=\"radiobtns\"> Option 02","                                            </label>","                                          </div>\t<!-- /controls -->\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","                                        ","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"radiobtns\">Combined Textbox</label>","\t\t\t\t\t\t\t\t\t\t\t","                                            <div class=\"controls\">","                                               <div class=\"input-prepend input-append\">","                                                  <span class=\"add-on\">$</span>","                                                  <input class=\"span2\" id=\"appendedPrependedInput\" type=\"text\">","                                                  <span class=\"add-on\">.00</span>","                                                </div>","                                              </div>\t<!-- /controls -->\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","                                        ","                                        ","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"radiobtns\">Textbox with Buttons </label>","\t\t\t\t\t\t\t\t\t\t\t","                                            <div class=\"controls\">","                                               <div class=\"input-append\">","                                                  <input class=\"span2 m-wrap\" id=\"appendedInputButton\" type=\"text\">","                                                  <button class=\"btn\" type=\"button\">Go!</button>","                                                </div>","                                              </div>\t<!-- /controls -->\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","                                        ","                                        ","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"radiobtns\">Dropdown in a button group</label>","\t\t\t\t\t\t\t\t\t\t\t","                                            <div class=\"controls\">","                                              <div class=\"btn-group\">","                                              <a class=\"btn btn-primary\" href=\"#\"><i class=\"icon-user icon-white\"></i> User</a>","                                              <a class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><span class=\"caret\"></span></a>","                                              <ul class=\"dropdown-menu\">","                                                <li><a href=\"#\"><i class=\"icon-pencil\"></i> Edit</a></li>","                                                <li><a href=\"#\"><i class=\"icon-trash\"></i> Delete</a></li>","                                                <li><a href=\"#\"><i class=\"icon-ban-circle\"></i> Ban</a></li>","                                                <li class=\"divider\"></li>","                                                <li><a href=\"#\"><i class=\"i\"></i> Make admin</a></li>","                                              </ul>","                                            </div>","                                              </div>\t<!-- /controls -->\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","                                        ","                                        ","                                        ","                                        ","                                        <div class=\"control-group\">\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"radiobtns\">Button sizes</label>","\t\t\t\t\t\t\t\t\t\t\t","                                            <div class=\"controls\">","                                              <a class=\"btn btn-large\" href=\"#\"><i class=\"icon-star\"></i> Star</a>","                                                <a class=\"btn btn-small\" href=\"#\"><i class=\"icon-star\"></i> Star</a>","                                                <a class=\"btn btn-mini\" href=\"#\"><i class=\"icon-star\"></i> Star</a>","                                              </div>\t<!-- /controls -->\t\t\t","\t\t\t\t\t\t\t\t\t\t</div> <!-- /control-group -->","                                        ","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t <br />","\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t\t","\t\t\t\t\t\t\t\t\t\t<div class=\"form-actions\">","\t\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary\">Save</button> ","\t\t\t\t\t\t\t\t\t\t\t<button class=\"btn\">Cancel</button>","\t\t\t\t\t\t\t\t\t\t</div> <!-- /form-actions -->","\t\t\t\t\t\t\t\t\t</fieldset>","\t\t\t\t\t\t\t\t</form>","\t\t\t\t\t\t\t</div>","\t\t\t\t\t\t\t<!-- /widget-content -->","\t\t\t\t\t\t</div>","\t\t\t\t\t\t<!-- /widget /////////////////////////////////////////////////////////////////////////////////////////////////////////-->","","\t\t\t\t\t\t<?php","\t\t\t\t\t    } //------------------------ customer -----------------------","\t\t\t\t\t  ?>","","\t\t\t\t\t</div> <!------------------------------------------------------------ end right ----------------------------------------------------------->","\t\t\t\t\t<!-- /span6 -->"],"id":5}]]},"ace":{"folds":[],"scrolltop":6706,"scrollleft":0,"selection":{"start":{"row":479,"column":5},"end":{"row":479,"column":5},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":478,"state":"start","mode":"ace/mode/php"}},"timestamp":1465625979287,"hash":"d0c0038f4f1c45f4e900e352f486c319ac089024"}