<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        }
        catch (e) {}
    </script>

    <!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">-->
    <!--    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">-->
    <!--        <button class="btn btn-success">-->
				<!--				<i class="ace-icon fa fa-signal"></i>-->
				<!--			</button>-->

    <!--        <button class="btn btn-info">-->
				<!--				<i class="ace-icon fa fa-pencil"></i>-->
				<!--			</button>-->

    <!--        <button class="btn btn-warning">-->
				<!--				<i class="ace-icon fa fa-users"></i>-->
				<!--			</button>-->

    <!--        <button class="btn btn-danger">-->
				<!--				<i class="ace-icon fa fa-cogs"></i>-->
				<!--			</button>-->
    <!--    </div>-->

    <!--    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">-->
    <!--        <span class="btn btn-success"></span>-->

    <!--        <span class="btn btn-info"></span>-->

    <!--        <span class="btn btn-warning"></span>-->

    <!--        <span class="btn btn-danger"></span>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li id="Dashboard" class="">
            <a href="index.php">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-check-square-o"></i>
                <span class="menu-text"> 審批申請 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="application.php?table=gatheringbattle">
                        <i class="menu-icon fa fa-caret-right"></i> 約戰申請
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="application.php?table=privatebooking">
                        <i class="menu-icon fa fa-caret-right"></i> 包埸申請
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="application.php?table=boardgamebooking">
                        <i class="menu-icon fa fa-caret-right"></i> 訂購申請
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> 記錄活動 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="event.php?table=gatheringbattle">
                        <i class="menu-icon fa fa-caret-right"></i> 記錄約戰
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="event.php?table=privatebooking">
                        <i class="menu-icon fa fa-caret-right"></i> 記錄包埸
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="event.php?table=boardgamebooking">
                        <i class="menu-icon fa fa-caret-right"></i> 記錄訂購
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-database"></i>
                <span class="menu-text"> 數據庫 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="database.php?table=admin">
                        <i class="menu-icon fa fa-caret-right"></i> admin
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="database.php?table=blacklist">
                        <i class="menu-icon fa fa-caret-right"></i> blacklist
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="database.php?table=boardgame">
                        <i class="menu-icon fa fa-caret-right"></i> boardgame
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="database.php?table=boardgamebooking">
                        <i class="menu-icon fa fa-caret-right"></i> boardgamebooking
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=boardgametype">
                        <i class="menu-icon fa fa-caret-right"></i> boardgametype
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="database.php?table=gatheringbattle">
                        <i class="menu-icon fa fa-caret-right"></i> gatheringbattle
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=location">
                        <i class="menu-icon fa fa-caret-right"></i> location
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=notification">
                        <i class="menu-icon fa fa-caret-right"></i> notification
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=photo">
                        <i class="menu-icon fa fa-caret-right"></i> photo
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=privatebooking">
                        <i class="menu-icon fa fa-caret-right"></i> privatebooking
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="database.php?table=users">
                        <i class="menu-icon fa fa-caret-right"></i> users
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-usd"></i>
                <span class="menu-text"> 更新收費 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="setting.php?table=gatheringbattleprice">
                        <i class="menu-icon fa fa-caret-right"></i> 約戰收費
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="setting.php?table=privatebookingprice">
                        <i class="menu-icon fa fa-caret-right"></i> 包埸收費
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-server"></i>
                <span class="menu-text"> 系統管理 </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            
            <ul class="submenu">
                
                <li class="">
    				<a href="#" class="dropdown-toggle">
    					<i class="menu-icon fa fa-caret-right"></i> 更新設定
    					<b class="arrow fa fa-angle-down"></b>
    				</a>
    
    				<b class="arrow"></b>
    
    				<ul class="submenu">
    				    
    					<li class="">
    						<a href="setting.php?table=message">
    							<i class="menu-icon fa fa-caret-right"></i> 通知訊息
    						</a>
    
    						<b class="arrow"></b>
    					</li>
    					
    					<li class="">
    						<a href="setting.php?table=indexsetting">
    							<i class="menu-icon fa fa-caret-right"></i> 首頁資訊數目
    						</a>
    
    						<b class="arrow"></b>
    					</li>
    					
    				</ul>
    			</li>
    			
    			<li class="">
                    <a href="uploadImage.php?table=photo">
                        <i class="menu-icon fa fa-caret-right"></i> 上載資訊圖片
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="uploadImage.php?table=boardgame">
                        <i class="menu-icon fa fa-caret-right"></i> 上載桌遊圖片
                    </a>

                    <b class="arrow"></b>
                </li>
                
            </ul>
        </li>
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>