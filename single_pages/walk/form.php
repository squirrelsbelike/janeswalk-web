<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<script type="text/javascript">
JanesWalk = <?= json_encode($front) ?>;
JanesWalk.form.datepicker_cfg.beforeShowDay =
  function (date) {
    var date_utc = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(),  date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds());
    var dateFormatted = moment(date_utc).format('YYYY-MM-DD');
    if ($.inArray(dateFormatted, dateSelected) != -1) {
      return {
        enabled : false,
        classes : 'selected'
      };
    }
  };
JanesWalk.form.datepicker_cfg.startDate = new Date();
JanesWalk.form.datepicker_cfg.endDate = new Date("May 23, 2020");
JanesWalk.form.datepicker_cfg.defaultDate = new Date();

</script>

<div style='display:none' class='pagejson' data-url='<?= DIR_REL . '/' . DISPATCHER_FILENAME  . '?cID=' . $c->getCollectionID() ?>'></div>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <span class="navbar-brand">
        <a href="<?= $nh->getCollectionURL($city) ?>" target="_blank">
          <i class="fa fa-map-marker"><?=t($city->getCollectionName()) . ', ' . t($country->getCollectionName()) ?></i>
        </a>
      </span>
      <div class="navbar-collapse collapse">
        <p class="navbar-text pull-right">
          <?= t('Logged in as') ?> <a href="<?=$this->url('/profile')?>" class="navbar-link" target="_blank"><?= $u->getUserName(); ?></a>
        </p>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<div class="container-fluid form-container">
  <div class="row">
    <div class="col-md-2">
      <div id="progress-panel">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" class="description" href="#description"><i class="fa fa-list-ol"></i> <?= t('Describe Your Walk') ?></a></li>
            <li ><a data-toggle="tab" class="route" href="#route"><i class="fa fa-map-marker"></i> <?= t('Share Your Route') ?></a></li>
            <li ><a data-toggle="tab" class="time-and-date" href="#time-and-date"><i class="fa fa-calendar"></i> <?= t('Set the Time & Date') ?></a></li>
            <li ><a data-toggle="tab" class="accessibility" href="#accessibility"><i class="fa fa-flag"></i> <?= t('Make it Accessible') ?></a></li>
            <li ><a data-toggle="tab" class="team" href="#team"><i class="fa fa-users"></i> <?= t('Build Your Team') ?></a></li>
          </ul>
          <br>
          <section id="button-group">
            <button class="btn btn-info btn-preview" id="preview-walk" title="Preview what you have so far." data-previewurl="<?=str_replace("format=json","format=html",$_REQUEST['load']); ?>"><?= t('Preview Walk') ?></button>
            <button class="btn btn-info btn-submit" id="btn-submit" title="Publishing will make your visible to all."><?= t('Publish Walk') ?></button>
            <button class="btn btn-info save" title="Save and return later" id="btn-save"><?= t('Save and return later') ?></button>
          </section>
        </div>
      </div>
    </div>
    <div class="col-md-7" id="main-panel" role="main">
      <div class="tab-content">
        <div class="tab-pane active" id="description">
          <div class="walk-submit lead">
            <div class="row">
              <div class="col-md-4">
                <img id="convo-marker" src="<?= $this->getThemePath() ?>/img/jw-intro-graphic.svg" alt="Jane's Walks are walking conversations.">
              </div>
              <div class="col-md-8"><h1><?= t('Hey there, %s!', $ui->getAttribute('first_name')) ?></h1>
                <p><?= t('Jane’s Walks are walking conversations about neighbourhoods. You can return to this form at any time, so there\'s no need to finish everything at once.') ?></p></div>
            </div>
          </div>
          <div class="page-header" data-section='description'>
          <h1><?= t('Describe Your Walk') ?></h1>
          </div>
          <form>
            <fieldset>
              <div class="item required">
                <label for="title"><?= t('Walk Title') ?></label>
                <div class="alert alert-info"><?= t('Something short and memorable.') ?></div>
                <input type="text" id="title" name="title" placeholder="" value="<?=htmlspecialchars($c->getCollectionname())?>" required>
              </div>
            </fieldset>
          </form>
          <form method="post" enctype="multipart/form-data" action="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/files/importers/quick" class="ccm-file-manager-submit-single">
            <hr>
            <div class="item required">
              <label for="walkphotos" id="photo-tip"><?= t('Upload a photo that best represents your walk.') ?></label>
              <iframe class="walkphotos" src="<?= REL_DIR_FILES_TOOLS ?>/files/image_upload"></iframe>
            </div>
          </form>
          <form>
            <hr>
            <fieldset>
              <div class="item required">
                <label for="shortdescription"><?= t('Your Walk in a Nutshell') ?></label>
                <div class="alert alert-info"><?= t('Build intrigue! This is what people see when browsing our walk listings.') ?></div>
                <textarea class="col-md-12 limit" id="shortdescription" name="shortdescription" rows="2" maxlength="140" required><?=htmlspecialchars($c->getAttribute('shortdescription'))?></textarea>
                <div class="text-right">
                 <p><?= t('Characters left') ?>: <span class="counter">140</span></p>
                </div>
              </div>
              <hr>
              <div class="item required">
                <label for="longdescription" id="longwalkdescription"><?= t('Walk Description') ?></label>
                <div class="alert alert-info">
                  <?= t('Help jump start the conversation on your walk by giving readers an idea of the discussions you\'ll be having on the walk together. We suggest including a couple of questions to get people thinking about how they can contribute to the dialog on the walk. To keep this engaging, we recommend keeping your description to 200 words.') ?>
                </div>
                <?= $c->getAttribute('longdescription') ?>
                <textarea class="textarea-wysiwyg col-md-12" id="longdescription" name="longdescription" rows="14"></textarea>
              </div>
            </fieldset>
            <?php if ($wards) { ?>
            <fieldset id="wards">
              <div class="item">
                <label for="wards"><?= t('Sub-locality') ?></label>
                <div class="alert alert-info"><?= t('Choose a specific neighbourhood or area where your walk will take place.') ?></div>
                <select id="ward" name="ward">
                  <?php foreach ($wards as $ward) { ?>
                  <option <?= $ward->selected ? 'selected' : '' ?> value="<?= addslashes($ward->value) ?>"><?= $ward->value ?></option>
                <?php } ?>
                </select>
              </div>
            </fieldset>
            <?php } ?>

            <?php /*  <fieldset>
              <legend>Additional Resources (Optional)</legend>
              <div class="alert alert-info">Upload a file such as a PDF, or provide a link to a relevant website or video. Please include no more than 3 additional references.</div>

              <ul class="unstyled" id="resource-list">
                <li class="resource-item">
                  <div class="thumbnail">
                    <div class="caption">

                      <div class="row">
                        <div class="col-md-5 item-select">
                          <label for="name">Upload document</label>
                          <input type="file" name="resource-file[]">
                          <div class="separator text-center">
                            <h2 class="lead">or</h2>
                          </div>
                          <label for="name">Share link</label>
                          <input class="input-link" type="text" placeholder="Website address" name="resource-title[]">
                        </div>
                        <div class="col-md-7 item-text">
                          <input type="text" placeholder="Resource Title" name="resource-title[]">
                          <textarea class="limit" rows="2" placeholder="Description" name="resource-description[]"></textarea>
                          <div class="text-right">
                            <p></p>Characters left: <span class="counter ">140</span></p>
                        </div>
                      </div>
                    </div>

                    <footer>
                      <a href="#" class="btn remove-resourceitem">Remove Resource</a>
                    </footer>
                  </div>
                </div>
              </li>

              <li class="resource-item-new hide">
                <div class="thumbnail">
                  <div class="caption">

                    <div class="row">
                      <div class="col-md-5 item-select">
                        <label for="name">Upload document</label>
                        <input type="file" name="resource-file[]">
                        <div class="separator text-center">
                          <h2 class="lead">or</h2>
                        </div>
                        <label for="name">Share link</label>
                        <input class="input-link" type="text" placeholder="Website address" name="resource-title[]">
                      </div>
                      <div class="col-md-7 item-text">
                        <input type="text" placeholder="Resource Title" name="resource-title[]">
                        <textarea class="limit" rows="2" placeholder="Description" name="resource-description[]"></textarea>
                        <div class="text-right">
                          <p></p>Characters left: <span class="counter ">140</span></p>
                      </div>
                    </div>
                  </div>

                  <footer>
                    <a href="#" class="btn remove-resourceitem">Remove Resource</a>
                  </footer>
                </div>
              </div>
            </li>

          </ul>

          <a href="#" class="btn btn-info" id="add-resource">Add Another Resource</a>

          </fieldset> */ ?>
        <?php if (!$is_nyc) { ?>
        <fieldset id="theme-select">
          <legend class="required-legend"><?= t('Themes') ?></legend>
          <div class="alert alert-info">
            <?= t('Pick between 1 and 3 boxes.') ?>
          </div>

          <div class="item">
            <div class="row">
              <div class="col-md-6">
                <fieldset>
                  <legend><?= t('Community') ?></legend>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-activist">  <?= t('Activism') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-truecitizen">  <?= t('Citizenry') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-goodneighbour">  <?= t('Community') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-writer">  <?= t('Storytelling') ?></label>
                </fieldset>
              </div>

              <div class="col-md-6">
                <fieldset>
                  <legend><?= t('City-building') ?></legend>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-architecturalenthusiast">  <?= t('Architecture') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-aesthete">  <?= t('Design') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-suburbanexplorer">  <?= t('Suburbs') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-moversandshakers">  <?= t('Transportation') ?></label>
                </fieldset>
              </div>
            </div>
          </div>

          <div class="item">
            <div class="row">
              <div class="col-md-6">

                <fieldset>
                  <legend><?= t('Society') ?></legend>

                  <label class="checkbox"><input type="checkbox" name="theme-civic-gender">  <?= t('Gender') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-health">  <?= t('Health') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-historybuff">  <?= t('Heritage') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-nativeissues">  <?= t('Native Issues') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-religion">  <?= t('Religion') ?></label>
                </fieldset>
              </div>
              <div class="col-md-6">
                <fieldset>
                  <legend><?= t('Expression') ?></legend>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-artist">  <?= t('Art') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-film">  <?= t('Film') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-bookworm">   <?= t('Literature') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-music">   <?= t('Music') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-play">   <?= t('Play') ?></label>
                </fieldset>
              </div>
            </div>
          </div>

          <div class="item">
            <div class="row">
              <div class="col-md-6">

                <fieldset>
                  <legend><?= t('The Natural World') ?></legend>

                  <label class="checkbox"><input type="checkbox" name="theme-nature-petlover">  <?= t('Animals') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-nature-greenthumb">  <?= t('Gardening') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-nature-naturelover">   <?= t('Nature') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-water">   <?= t('Water') ?></label>
                </fieldset>
              </div>
              <div class="col-md-6">

                <fieldset>
                  <legend><?= t('Modernity') ?></legend>

                  <label class="checkbox"><input type="checkbox" name="theme-civic-international">  <?= t('International Issues') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-military">  <?= t('Military') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-civic-commerce">  <?= t('Commerce') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-nightowl">  <?= t('Night Life') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-techie">  <?= t('Technology') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-urban-sports">  <?= t('Sports') ?></label>
                  <label class="checkbox"><input type="checkbox" name="theme-culture-foodie">  <?= t('Food') ?></label>
                </fieldset>
              </div>
            </div>
          </div>
        </fieldset>
<?php
        } // end NYC check ?>
        <hr>
        <input class="btn btn-primary btn-large section-save" type="submit" value="<?= t('Next') ?>" data-next="route" href="#route"><br><br>
      </form>
    </div>

    <div class="tab-pane" id="route">
      <div class="page-header" data-section="route">
        <h1><?= t('Share Your Route') ?></h1>
      </div>
      <div class="alert alert-info"><?= t('Make sure to add a description to your meeting place, and the last stop. This is how people will find you on the day of your walk.') ?></div>
      <div id="route-help-panel">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#route-menu" href="#route-menu"><h2 class="lead"><?= t('Need help building your route?') ?></h2></a>

        <div id="route-menu" class="collapse" style="height:0;">
          <div class="row">
            <div class="col-md4">
              <h4>1. <?= t('Set a Meeting Place') ?></h4>
              <ol>
                <li><?= t('Click "Meeting Place" to add a pinpoint on the map') ?></li>
                <li><?= t('Click and drag it into position') ?></li>
                <li><?= t('Fill out the form fields and press Save Meeting Place') ?></li>
              </ol>
            </div>
            <div class="col-md-4">
              <h4>2. <?= t('Add Stops') ?></h4>
              <ol>
                <li><?= t('Click "Add Stop" to add a stop on the map') ?></li>
                <li><?= t('Click and drag it into position') ?></li>
                <li><?= t('Fill out the form fields and press Save Stop') ?></li>
                <li><?= t('Repeat to add more stops') ?></li>
              </ol>
            </div>
            <div class="col-md-4">
              <h4>3. <?= t('Add Route') ?></h4>
              <ol>
                <li><?= t('Click Add Route') ?></li>
                <li><?= t('A point will appear on your meeting place, now click on each of the stops that flow to connect them.') ?></li>
                <li><?= t('Click and drag the circles on the orange lines to make the path between each stop. Right click on a point to delete it.') ?></li>
                <li><?= t('Click Save Route') ?></li></ol>
              <ul>
                <li><?= t('If you want to delete your route to start over, click ') ?><a href="" class="clear-route"><?= t('Clear Route') ?></a>. <?= t('Your Stops will not be deleted') ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="row" id="map-control-bar">
        <button id="addmeetingplace" class="btn col-md-1"><i class="fa icon-flag-jw"></i> <?= t('Set a Meeting Place') ?></button>
        <div class="addroute-wrapper col-md-1"><button id="addpoint" class="btn"><i class="fa icon-map-marker-jw"></i> <?= t('Add Stop') ?></button><div class="disable-alert"></div></div>
        <button id="addroute" class="btn col-md-1"><i class="icon-map-route"></i> <?= t('Add Route') ?></button>
        <button class="btn clear-route col-md-1"><i class="fa fa-eraser"></i> <?= t('Clear Route') ?></button>

      </div>
      <div class="map-notifications"></div>
      <div id="map-canvas"></div>

      <h3><?= t('Walk Stops') ?></h3>

      <table id="route-stops" class="table table-bordered table-hover">
        <thead>
          <tr>
          <th><?= t('Title') ?></th>
          <th><?= t('Description') ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <td colspan="3"><p><?= t('You haven\'t set any stops yet.') ?></p></td>
          </tr>
        </tbody>
      </table>

      <hr>
      <a href="#time-and-date" class="btn btn-primary btn-large section-save" data-toggle="tab"><?= t('Next') ?></a><br><br>
    </div>

    <div class="tab-pane" id="time-and-date">
      <div class="tab-content" id="walkduration">
        <div class="tab-pane active" id="time-and-date-select">
          <div class="page-header" data-section='time-and-date'>
            <h1><?= t('Set the Time and Date') ?></h1>
          </div>
          <legend ><?= t('Pick one of the following:') ?></legend>
          <div class="row">
            <ul class="thumbnails" id="block-select">
              <?php if (false && !in_array($city->getCollectionID(), [235, 276])) { ?>
              <li class="col-md-6">
                <a href="#time-and-date-all" data-toggle="tab">
                  <div class="thumbnail">
                    <img src="<?=$this->getThemePath();?>/img/time-and-date-full.png" />
                    <div class="caption">
                      <div class="text-center">
                        <h4><?= t('By Request') ?></h4>
                      </div>
                      <p><?= t('Highlight times that you\'re available to lead the walk, or leave your availability open. People will be asked to contact you to set up a walk.') ?></p>
                    </div>
                  </div>
                </a>
              </li>
              <?php } ?>
              <li class="col-md-6">
                <a href="#time-and-date-set" data-toggle="tab">
                  <div class="thumbnail">
                    <img src="<?= ($this->getThemePath()) ?>/img/time-and-date-some.png" />
                    <div class="caption">
                      <div class="text-center">
                        <h4><?= t('Pick Your Date') ?></h4>
                      </div>
                      <p><?= t('Set specific dates and times that this walk is happening.') ?></p>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="tab-pane hide" id="time-and-date-set">
          <div class="page-header" data-section='time-and-date'>
            <h1><?= t('Time and Date') ?></h1>
            <p class="lead"><?= t('Select the date and time your walk is happening.') ?></p>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="date-picker"></div>
            </div>
            <div class="col-md-6">
              <div class="thumbnail">
                <div class="caption">
                  <small><?= t('Date selected') ?>:</small>
                  <h4 class="date-indicate-set" data-dateselected=""></h4>
                  <hr>
                  <label for="walk-time"><?= t('Start Time') ?>:</label>

                  <input id="walk-time" type="text" class="time ui-timepicker-input input-small" autocomplete="off">

                  <label for="walk-time"><?= t('Approximate Duration of Walk') ?>:</label>
                  <select name="duration" id="walk-duration">
                    <option value="30 Minutes">30 Minutes</option>
                    <option value="1 Hour">1 Hour</option>
                    <option value="1 Hour, 30 Minutes" selected>1 Hour, 30 Minutes</option>
                    <option value="2 Hours">2 Hours</option>
                    <option value="2 Hours, 30 Minutes">2 Hours, 30 Minutes</option>
                    <option value="3 Hours">3 Hours</option>
                    <option value="3 Hours, 30 Minutes">3 Hours, 30 Minutes</option>
                  </select><hr>
                  <button class="btn btn-primary" id="save-date-set"><?= t('Add Date') ?></button>
                </div>

              </div>
            </div>
          </div>

          <br>
          <table class="table table-bordered table-hover" id="date-list-set">
            <thead>
              <tr>
                <th><?= t('Date') ?></th>
                <th><?= t('Start Time') ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

          <hr>
          <a href="#time-and-date-select" data-toggle="tab" class="clear-date"><?= t('Clear schedule and return to main Time and Date page') ?></a>

          <hr>
          <a href="#accessibility" class="btn btn-primary btn-large section-save" data-toggle="tab"><?= t('Next') ?></a><br><br>
        </div>
        <div class="tab-pane hide" id="time-and-date-all">
          <div class="page-header" data-section='time-and-date'>
            <h1><?= t('Time and Date') ?></h1>
            <p class="lead"><?= t('Your availability will be visible to people on your walk page and they’ll be able to send you a walk request.') ?></p>
          </div>
          <label class="checkbox">
            <input type="checkbox" name="open"> <?= t('Leave my availability open. Allow people to contact you to set up a walk.') ?>
          </label>
          <br>

          <div class="row">
            <div class="col-md-6">
              <div class="date-picker"></div>
            </div>
            <div class="col-md-6">
              <div class="thumbnail">
                <div class="caption">
                  <div class="date-select-group">
                    <small><?= t('Date selected') ?>:</small>
                    <h4 class="date-indicate-all"></h4>
                    <hr>
                  </div>
                  <label for="walk-duration"><?= t('Approximate Duration of Walk') ?>:</label>
                  <select name="duration" id="walk-duration">
                    <option value="30 Minutes">30 Minutes</option>
                    <option value="1 Hour">1 Hour</option>
                    <option value="1 Hour, 30 Minutes" selected>1 Hour, 30 Minutes</option>
                    <option value="2 Hours">2 Hours</option>
                    <option value="2 Hours, 30 Minutes">2 Hours, 30 Minutes</option>
                    <option value="3 Hours">3 Hours</option>
                    <option value="3 Hours, 30 Minutes">3 Hours, 30 Minutes</option>
                  </select>
                  <div class="date-select-group">
                    <hr>
                    <button class="btn btn-primary" id="save-date-all"><?= t('Add Date') ?></button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <br>
          <table class="table table-bordered table-hover" id="date-list-all">
            <thead>
              <tr>
                <th><?= t('My Available Dates') ?></th>
                <th><?= t('Approximate Duration') ?></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

          <hr>
          <a href="#time-and-date-select" data-toggle="tab" class="clear-date"><?= t('Clear schedule and return to main Time and Date page') ?></a>

          <hr>
          <a href="#accessibility" class="btn btn-primary btn-large section-save" data-toggle="tab"><?= t('Next') ?></a><br><br>
        </div>
      </div>
    </div>

    <div class="tab-pane" id="accessibility">
      <div class="page-header" data-section='accessibility'>
        <h1><?= t('Make it Accessible') ?></h1>
      </div>
      <div class="item">
        <fieldset>
          <legend class="required-legend"><?= t('How accessible is this walk?') ?></legend>
          <div class="row">
            <div class="col-md-6">
              <label class="checkbox"><input type="checkbox" name="accessible-familyfriendly">  <?= t('Family friendly') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-wheelchair">  <?= t('Wheelchair accessible') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-dogs">  <?= t('Dogs welcome') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-strollers">  <?= t('Strollers welcome') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-bicycles">  <?= t('Bicycles welcome') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-steephills">  <?= t('Steep hills') ?></label>
            </div>
            <div class="col-md-6">
              <label class="checkbox"><input type="checkbox" name="accessible-uneven">  <?= t('Wear sensible shoes (uneven terrain)') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-busy">  <?= t('Busy sidewalks') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-bicyclesonly">  <?= t('Bicycles only') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-lowlight">  <?= t('Low light or nighttime') ?></label>
              <label class="checkbox"><input type="checkbox" name="accessible-seniors">  <?= t('Senior Friendly') ?></label>
            </div>
          </div>
        </fieldset>
      </div>

      <div class="item">
        <fieldset>
          <legend><?= t('What else do people need to know about the accessibility of this walk?') ?> (<?= t('Optional') ?>)</legend>
          <textarea rows="3" name="accessible-info"></textarea>
        </fieldset>
      </div>

      <div class="item">
        <fieldset>
          <legend id="transit"><?= t('How can someone get to the meeting spot by public transit?') ?> (<?= t('Optional') ?>)</legend>
          <div class="alert alert-info">
            <?= t('Nearest subway stop, closest bus or streetcar lines, etc.') ?>
          </div>
          <textarea rows="3" name="accessible-transit"></textarea>
        </fieldset>
      </div>

      <div class="item">
        <fieldset>
          <legend><?= t('Where are the nearest places to park?') ?> (<?= t('Optional') ?>)</legend>
          <textarea rows="3" name="accessible-parking"></textarea>
        </fieldset>
      </div>

      <div class="item">
        <fieldset>
          <legend class="required-legend" ><?= t('How will people find you?') ?></legend>
          <div class="alert alert-info">
            <?= t('Perhaps you will be holding a sign, wearing a special t-shirt or holding up an object that relates to the theme of your walk. Whatever it is, let people know how to identify you.') ?>
          </div>
          <textarea rows="3" name="accessible-find"></textarea>
        </fieldset>
      </div>

      <hr>
      <a href="#team" class="btn btn-primary btn-large section-save" data-toggle="tab"><?= t('Next') ?></a><br><br>
    </div>

    <div class="tab-pane" id="team">
      <div class="page-header" data-section="team">
        <h1><?= t('Build Your Team') ?></h1>
      </div>

      <div class="team-member thumbnail useredited" id="walk-leader-me">
        <fieldset>
          <input type="hidden" name="type[]" value="you">
          <input type="hidden" name="user_id[]" value="<?= $owner->getUserID() ?>">
          <legend><?= t('You') ?></legend>
          <div class="row" id="walkleader">
            <div class="col-md-9">
              <div class="item required">
                <label for="name"><?= t('Name') ?></label>
                <input type="text" class="input-small" name="name-first[]" id="name" placeholder="First" value="<?= htmlspecialchars($owner->getAttribute("first_name")) ?>">
                <input type="text" class="input-small" name="name-last[]" id="name" placeholder="Last" value="<?= htmlspecialchars($owner->getAttribute("last_name")) ?>">
              </div>

              <div class="item required">
                <label for="role"><?= t('Role') ?></label>
                <select id="role" name="role[]">
                  <option value="walk-leader" selected><?= t('Walk Leader') ?></option>
                  <option value="co-walk-leader"><?= t('Co-Walk Leader') ?></option>
                  <option value="walk-organizer"><?= t('Walk Organizer') ?></option>
                </select>
              </div>
              <div class="item hide" id="primary-walkleader-select">
                <label class="checkbox"><input type="checkbox" name="primary[]" class="role-check" checked>  <?= t('Primary Walk Leader') ?></label>
              </div>
              <div class="item required">
                <label for="bio"><?= t('Introduce yourself') ?></label>
                <div class="alert alert-info">
                  <?= t('We recommend keeping your bio under 60 words') ?>
                </div>
                <textarea class="col-md-12" id="bio" rows="6" name="bio[]"><?= htmlspecialchars($owner->getAttribute("bio")) ?></textarea>
              </div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6 required">
                  <label for="you-email"><i class="fa fa-envelope"></i> <?= t('Email') ?></label>
                  <input type="email" class="input-large" id="you-email" placeholder="" name="email[]" value="<?=$owner->getUserEmail()?>">
                </div>

                <div class="col-md-6">
                  <label for="leader-twitter"><i class="fa fa-twitter"></i> Twitter</label>
                  <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input class="col-md-12" id="leader-twitter" type="text" placeholder="Username" name="twitter[]" value="<?= htmlspecialchars($owner->getAttribute("twitter")) ?>">
                  </div>
                </div>

              </div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="facebook"><i class="fa fa-facebook-square"></i> Facebook</label>
                  <input type="text" class="input-large" id="facebook" placeholder="" name="facebook[]" value="<?=htmlspecialchars($owner->getAttribute("facebook"))?>">
                </div>
                <div class="col-md-6">
                <label for="website"><i class="fa fa-link"></i> <?= t('Website') ?></label>
                  <input type="text" class="input-large" id="website" placeholder="" name="website[]" value="<?=htmlspecialchars($owner->getAttribute("website"))?>">
                </div>
              </div>

              <hr>
              <div class="private">
                <h4><?= t('We\'ll keep this part private') ?></h4>
                <div class="alert alert-info">
                  <?= t('We\'ll use this information to contact you about your walk submission. We wont share this information with 3rd parties.') ?>
                </div>

                <div class="row" id="newwalkleader">
                  <div class="col-md-6 tel required">
                    <label for="phone"><i class="fa fa-phone-square"></i> <?= t('Phone Number') ?></label>
                    <input type="tel" maxlength="18" class="input-large" id="phone" placeholder="" name="phone[]" value="<?=htmlspecialchars($owner->getAttribute("phone"))?>">
                  </div>
                </div>
              </div>
              <?php
                if ($city->getCollectionName() === 'Toronto') {
              ?>
                <div class="prompt">
                  <hr />
                  <label>In need of volunteers?</label>
                  From helping you carry props to answering
                  questions about the festival and more, there are loads of
                  enthusiastic volunteers hoping to lend you a helping hand!<br /><br />
                  <a href="https://jfrolick.typeform.com/to/n5H8nL" target="_blank">Follow this link</a>
                  and the Project Office will match you up with volunteers as per
                  your request!
                </div>
              <?php
                }
              ?>
            </div>
          </div>
        </fieldset>
      </div>

      <!--Additional Members -->

      <div id="walk-members">

      </div>

      <div class="thumbnail team-member" id="add-member">
        <h2><?= t('Who else is involved with this walk?') ?></h2>
        <h3 class="lead"><?= t('Click to add team members to your walk') ?> (<?= t('Optional') ?>)</h3>
        <div class="team-set">
          <div class="team-row">
            <section class="new-member" id="new-walkleader" title="Add New Walk Leader" data-new="walk-leader-new">
              <div class="icon"></div>
              <h4 class="title text-center"><?= t('Walk Leader') ?></h4>
              <p><?= t('A person presenting information, telling stories, and fostering discussion during the Jane\'s Walk.') ?></p>
            </section>
            <section class="new-member" id="new-walkorganizer" title="Add New Walk Organizer" data-new="walk-organizer-new">
              <div class="icon"></div>
              <h4 class="title text-center"><?= t('Walk Organizer') ?></h4>
              <p><?= t('A person responsible for outreach to new and returning Walk Leaders and Community Voices.') ?></p>
            </section>
          </div>
          <div class="team-row">
            <section class="new-member" id="new-communityvoice" title="Add A Community Voice" data-new="community-voice-new">
              <div class="icon"></div>
              <h4 class="title text-center"><?= t('Community Voice') ?></h4>
              <p><?= t('A community member with stories and/or personal experiences to share.') ?></p>
            </section>
            <section class="new-member" id="new-othermember" title="Add another helper to your walk" data-new="othermember-new">
              <div class="icon"></div>
              <h4 class="title text-center"><?= t('Volunteers') ?></h4>
              <p><?= t('Other people who are helping to make your walk happen.') ?></p>
            </section>
          </div>
        </div>
      </div>

      <!-- Start Walk Leader -->

      <div class="thumbnail team-member hide walk-leader clearfix" id="walk-leader-new">
        <fieldset>
          <input type="hidden" name="type[]" value="leader">
          <input type="hidden" name="user_id[]" value="-1">
          <legend><?= t('Walk Leader') ?></legend>

          <div class="row" id="walkleader">
            <div class="col-md-9">
              <div class="item required">
                <label for="name"><?= t('Name') ?></label>
                <div class="item">
                  <form class="form-inline">
                    <input type="text" class="input-small" id="name" placeholder="First" name="name-first[]" />
                    <input type="text" class="input-small" id="name" placeholder="Last" name="name-last[]" />
                  </form>
                </div>
              </div>
              <div class="item" id="primary-walkleader-select">
                <label class="checkbox"><input type="checkbox" class="role-check" name="primary[]">  <?= t('Primary Walk Leader') ?></label>
              </div>

              <div class="item required">
                <label for="bio"><?= t('Introduce the walk leader') ?></label>
                <div class="alert alert-info">
                  <?= t('We recommend keeping the bio under 60 words') ?>
                </div>
                <textarea class="col-md-12" id="bio" rows="6" name="bio[]"></textarea>
              </div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="prependedInput"><i class="fa fa-twitter"></i> Twitter</label>
                  <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input id="prependedInput" class="col-md-12" type="text" placeholder="Username" name="twitter[]">
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="facebook"><i class="fa fa-facebook-square"></i> Facebook</label>
                  <input type="text" class="input-large" id="facebook" placeholder="" name="facebook[]">
                </div>
              </div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="website"><i class="fa fa-link"></i> <?= t('Website') ?></label>
                  <input type="text" class="input-large" id="website" placeholder="" value="" name="website[]">
                </div>
              </div>

              <hr>

              <h4><?= t('Private') ?></h4>
              <div class="alert alert-info">
                <?= t('We\'ll use this information to contact you about your walk submission. We wont share this information with 3rd parties.') ?></div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6 required">
                  <label for="email"><i class="fa fa-envelope"></i> <?= t('Email') ?></label>
                  <input type="email" class="input-large" id="email" placeholder="Email" name="email[]">
                </div>
                <div class="col-md-6 tel">
                  <label for="phone"><i class="fa fa-phone-square"></i> <?= t('Phone Number') ?></label>
                  <input type="tel" maxlength="16" class="input-large" id="phone" placeholder="" name="phone[]">
                </div>
              </div>
            </div>
          </div>
        </fieldset>
        <footer>
          <button class="btn remove-team-member"><?= t('Remove Team Member') ?></button>
        </footer>
      </div>

      <!-- Start Walk Organizer -->

      <div class="thumbnail team-member walk-organizer hide" id="walk-organizer-new">
        <fieldset>
          <legend><?= t('Walk Organizer') ?></legend>
          <input type="hidden" name="type[]" value="organizer">
          <input type="hidden" name="user_id[]" value="-1">
          <div class="row" id="walkleader">
            <div class="col-md-9">
              <div class="item required">
                <label for="name"><?= t('Name') ?></label>
                <form class="form-inline">
                  <input type="text" class="input-small" id="name" placeholder="First" name="name-first[]">
                  <input type="text" class="input-small" id="name" placeholder="Last" name="name-last[]">
                </form>
              </div>
              <label for="affiliation"><?= t('Affilated Institution') ?> (<?= t('Optional') ?>)</label>
              <input type="text" class="input-large" id="name" placeholder="e.g. City of Toronto" name="institution[]">
              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="website"><i class="fa fa-link"></i> <?= t('Website') ?></label>
                  <input type="text" class="input-large col-md-12" id="website" placeholder="" value="" name="name-website[]">
                </div>
              </div>
            </div>
          </div>
        </fieldset>
        <footer>
          <button class="btn remove-team-member"><?= t('Remove Team Member') ?></button>
        </footer>
      </div>

      <!-- Start Community Voice -->

      <div class="thumbnail team-member hide community-voice" id="community-voice-new">
        <fieldset>
          <input type="hidden" name="type[]" value="community">
          <input type="hidden" name="user_id[]" value="-1">
          <legend id="community-voice"><?= t('Community Voice') ?></legend>
          <div class="row" id="walkleader">
            <div class="col-md-9">
              <div class="item required">
                <label for="name"><?= t('Name') ?></label>
                <form class="form-inline">
                  <input type="text" class="input-small" id="name" placeholder="First" name="name-first[]">
                  <input type="text" class="input-small" id="name" placeholder="Last" name="name-last[]">
                </form>
              </div>
              <div class="item">
                <label for="bio"><?= t('Tell everyone about this person') ?></label>
                <div class="alert alert-info">
                  <?= t('We recommend keeping the bio under 60 words') ?>
                </div>
                <textarea class="col-md-12" id="bio" rows="6" name="bio[]"></textarea>
              </div>
              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="prependedInput"><i class="fa fa-twitter"></i> Twitter</label>
                  <div class="input-prepend">
                    <span class="add-on">@</span>
                    <input class="col-md-12" id="prependedInput" type="text" placeholder="Username" name="twitter[]">
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="facebook"><i class="fa fa-facebook-square"></i> Facebook</label>
                  <input type="text" class="input-large" id="facebook" placeholder="" name="facebook[]">
                </div>
              </div>
              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="website"><i class="fa fa-link"></i> <?= t('Website') ?></label>
                  <input type="text" class="input-large col-md-12" id="website" placeholder="" value="" name="website[]">
                </div>
              </div>
            </div>
          </div>
        </fieldset>
        <footer>
          <button class="btn remove-team-member"><?= t('Remove Team Member') ?></button>
        </footer>
      </div>

      <!-- Other -->
      <div class="thumbnail team-member hide othermember" id="othermember-new">
        <fieldset>
          <legend id="othermember"><?= t('Volunteers') ?></legend>
          <input type="hidden" name="type[]" value="volunteer">
          <input type="hidden" name="user_id[]" value="-1">
          <div class="row" id="walkleader">
            <div class="col-md-9">
              <div class="item required">
                <label for="name"><?= t('Name') ?></label>
                <form class="form-inline">
                  <input type="text" class="input-small" id="name" placeholder="First" name="name-first[]">
                  <input type="text" class="input-small" id="name" placeholder="Last" name="name-last[]">
                </form>
              </div>

              <div class="item required">
                <label for="role"><?= t('Role') ?></label>
                <input type="text" id="role" name="role[]">
              </div>

              <div class="row" id="newwalkleader">
                <div class="col-md-6">
                  <label for="website"><i class="fa fa-link"></i> <?= t('Website') ?></label>
                  <input type="text" class="input-large col-md-12" id="website" placeholder="" value="" name="website[]">
                </div>
              </div>

            </div>
          </div>
        </fieldset>
        <footer>
          <button class="btn remove-othermember"><?= t('Remove Team Member') ?></button>
        </footer>
      </div>
      <hr>
      <button class="btn btn-primary btn-large section-save" id="section-save"><?= t('Save') ?></button><br><br>
    </div>
  </div>
</div>

<div class="col-md-3" id="tips-column">
  <aside id="tips-panel" role="complementary">
    <div class="popover right" id="city-organizer" style="display:block;">
      <h3 class="popover-title" data-toggle="collapse" data-target="#popover-content"><i class="fa fa-envelope"></i> <?= t('Contact City Organizer for help') ?></h3>
      <div class="popover-content collapse in" id="popover-content">
        <?= ($avatar = $av->getImagePath($ui_cityorganizer)) ? "<div class='u-avatar' style='background-image:url({$avatar})'></div>" : null; ?>
        <p>
          <?= t('Hi! I\'m %s, the City Organizer for Jane\'s Walk %s. I\'m here to help, so if you have any questions, please', ($ui_cityorganizer->getAttribute('first_name') ?: $ui_cityorganizer->getUserName()), $city->getCollectionName()) ?> <strong><a href='mailto:<?= $ui_cityorganizer->getUserEmail() ?>'><?= t('email me') ?>!</a></strong></p>
      </div>
    </div>
  </aside>
</div>
  </div>
</div>

<!-- Publish Model 1 -->
<div id="publish-warning" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?= t('Okay, You\'re Ready to Publish') ?></h3>
  </div>
  <div class="modal-body">
    <p><?= t('Just one more thing! Once you hit publish your walk will be live on Jane\'s Walk right away. You can return at any time to make changes.') ?></p>
  </div>

  <div class="modal-footer">
    <div class="pull-left">
      <a href="" class="walkthrough close" data-dismiss="modal"> <?= t('Bring me back to edit') ?></a>
    </div>
    <a href="<?php echo $this->url('/profile') ?>">
      <button class="btn btn-primary walkthrough" data-step="publish-confirmation"><?= t('Publish') ?></button></a>
  </div>

</div>

<!-- Publish Model 2 -->
<div id="publish-confirmation" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Your Walk Has Been Published!</h3>
  </div>
  <div class="modal-body">
    <p>Congratulations! Your walk is now available for all to peruse.</p>
    <h2 class="lead"> Don't forget to share your walk!</h2>
    <label>Your Walk Web Address:</label>
    <input type="text" class="clone js-url-field" value="http://janeswalk.tv/be-there-be-square.html" readonly="readonly">
    <hr>
    <button class="btn facebook"><i class="fa fa-facebook-sign"></i> Share on Facebook</button>
    <button class="btn twitter"><i class="fa fa-twitter-sign"></i> Share on Twitter</button>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary walkthrough">Close</button>
  </div>
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?= t('Preview of your Walk') ?></h3>
  </div>
  <div class="modal-body">
    <iframe src="" frameborder="0">
    </iframe>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close" data-dismiss="modal"><?= t('Close Preview') ?></a>
  </div>
</div>
