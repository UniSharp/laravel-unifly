<!DOCTYPE html>
<html>
  <head>
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/sb-admin-2.css" rel="stylesheet">
    <link href="/css/unifly.css" rel="stylesheet">
    <title>Unifly UI</title>
  </head>
  <body>
    <!--======[ Plugins ]======-->
    <!--======[ Form ]======-->
    <!--======[ Input fields ]======-->
    <div class="container">
      <div id="title" style="margin-top: 250px;" class="text-center"></div>
      <div class="fade">
        <div class="jumbotron">
          <div class="row">
            <div class="col-md-2">
              <label class="form-control-static">Entity 名稱：</label>
            </div>
            <div class="col-md-4">
              <input id="name_en" type="text" placeholder="英文" name="name_en" tabindex="1" class="form-control">
            </div>
            <div class="col-md-4">
              <input id="name_tw" type="text" placeholder="中文" name="name_tw" tabindex="2" class="form-control">
            </div>
            <div class="col-md-2">
              <div class="fade"><a id="init" tabindex="3" class="btn btn-outline btn-info"><i class="fa fa-play-circle"></i> Go</a></div><a id="destroy" class="btn btn-outline btn-danger"><i class="fa fa-times"></i> 刪除</a>
            </div>
          </div>
        </div>
      </div>
      <div id="content" class="fade">
        <div style="height:5px;" class="progress">
          <div id="progress_bar" style="background-color:#3BE8B0;" class="progress-bar"></div>
        </div>
        <div class="tab-content">
          <div id="columns" step="1" class="tab-pane fade active in">
            <nav>
              <ul class="pager">
                <li class="next"><a href="#features" data-toggle="tab"><span>下一步&nbsp;<i class="fa fa-arrow-circle-right"></i></span></a></li>
              </ul>
            </nav>
            <h2 class="page-header">設定欄位</h2>
            <div class="table-responsive">
              <table class="table table-striped table-middle table-hover table-middle">
                <thead>
                  <tr>
                    <th width="5%">操作</th>
                    <th width="25%">欄位名稱&nbsp;<i data-toggle="tooltip" title="資料表、新增、編輯頁面中的欄位名稱，接受英文與底線" class="fa fa-question-circle"></i></th>
                    <th width="25%">意義&nbsp;<i data-toggle="tooltip" title="資料表中該的欄位的 comment，請詳細描述，接受中文" class="fa fa-question-circle"></i></th>
                    <th width="15%">使用的 Mixin</th>
                    <th width="15%">資料類型</th>
                    <th width="10%">是否必填</th>
                  </tr>
                </thead>
                <tbody id="column_wrapper">
                  <tr data-id="" class="hide">
                    <td><a class="btn btn-circle btn-danger btn-outline btn-delete"><i class="fa fa-times"></i></a></td>
                    <td class="del-name">
                      <input placeholder="欄位名稱 (英文)" class="form-control column_name">
                    </td>
                    <td>
                      <input placeholder="資料庫欄位註解" required class="form-control comment">
                    </td>
                    <td>
                      <select class="form-control mixin">@foreach($mixins as $mixin)
                        <option value="{{$mixin}}">{{$mixin}}</option>@endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control data_type">@foreach($data_types as $data_type)
                        <option value="{{$data_type}}">{{$data_type}}</option>@endforeach
                      </select>
                    </td>
                    <td>
                      <input type="checkbox" name="enabled">
                    </td>
                  </tr>
                </tbody>
              </table><a id="btn-add" class="btn btn-block btn-default"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div id="features" step="2" class="tab-pane fade">
            <nav>
              <ul class="pager">
                <li class="previous"><a href="#columns" data-toggle="tab"><span>上一步</span></a></li>
                <li class="next"><a href="#progress" data-toggle="tab" id="submit"><span>建立&nbsp;<i class="fa fa-arrow-circle-right"></i></span></a></li>
              </ul>
            </nav>
            <h2 class="page-header">功能選項</h2>
            <div class="row">
              <div class="col-md-3"><a data-img="/img/dnd-sort.jpg" class="thumbnail">
                  <h4 class="caption">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="sort"><strong>需要排序</strong>
                      </label>
                    </div>
                  </h4></a><a data-img="/img/hidden_row.png" class="thumbnail">
                  <h4 class="caption">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="hidden_row"><strong>需要 hidden row</strong>
                      </label>
                    </div>
                  </h4></a><a data-img="/img/laravel-translatable.png" class="thumbnail">
                  <h4 class="caption">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="translatable"><strong>需要翻譯</strong>
                      </label>
                    </div>
                  </h4></a><a data-img="/img/Excel.png" class="thumbnail">
                  <h4 class="caption">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="export"><strong>需要匯出</strong>
                      </label>
                    </div>
                  </h4></a><a data-img="/img/Excel.png" class="thumbnail">
                  <h4 class="caption">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="import"><strong>需要匯入</strong>
                      </label>
                    </div>
                  </h4></a></div>
              <div class="col-md-9"><img id="feature_preview" style="max-width:100%"></div>
            </div>
          </div>
          <div id="progress" step="3" class="tab-pane fade">
            <h2 class="page-header">建構進度</h2>
            <div class="row">
              <div class="col-md-4">
                <h3 class="build_title">Model</h3>
                <h4 id="Migration" class="build_subtitle">Table</h4>
                <h4 id="Model" class="build_subtitle">Entity</h4>
                <h4 id="Repository" class="build_subtitle">Repository</h4>
              </div>
              <div class="col-md-4">
                <h3 class="build_title">View</h3>
                <h4 id="View" class="build_subtitle">Pug</h4>
              </div>
              <div class="col-md-4">
                <h3 class="build_title">Controller</h3>
                <h4 id="Route" class="build_subtitle">Route</h4>
                <h4 id="Controller" class="build_subtitle">Controller</h4>
                <h4 id="Presenter" class="build_subtitle">Presenter</h4>
                <h4 id="FormRequest" class="build_subtitle">Form requests</h4>
              </div>
            </div><a id="btn-checkout" href="/backend/article" target="_blank" style="margin-top:30px" class="btn btn-block btn-info btn-outline"><i class="fa fa-search"></i>&nbsp;開始使用新功能</a>
          </div>
        </div>
      </div>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/unifly.js"></script>
    <script>
      let fancy_introduction = true;
      let default_title = 'Unifly UI';
      let arr_items_to_build = ['Route', 'Model', 'Controller', 'Presenter', 'Repository', 'Migration', 'FormRequest', 'View'];
      let csrf_token = "{{csrf_token()}}";

      $(document).ready(function () {
        $('#destroy').hide();
        $('[data-toggle="tooltip"]').tooltip();
        $('.build_title').append($('<i>').addClass('pull-right fa fa-tw'));
        $('.build_subtitle').append($('<i>').addClass('pull-right fa fa-tw'));

        showIntroduction();
        cloneNewColumn();
      });

      $('#name_en').blur(showInitButton);
      $('#name_tw').keyup(updateTitle);

      $('#init').keydown(function (event) {
          if (event.keyCode == 32 || event.keyCode == 13) {
            showDetailSettings();
          }
        })
        .click(showDetailSettings)
        .focus(hoverInitButton)
        .blur(unhoverInitButton);

      $('a[data-toggle=tab]').click(function () {
        if ($(this).attr('id') == 'submit' && !allFieldsAreValid()) {
          return;
        }
        setProgressToStep($($(this).attr('href')).attr('step'));
        $(this).parent('li').removeClass('active');
      });

      $('a.thumbnail').mouseenter(function () {
        $('#feature_preview').attr('src', $(this).data('img'));
        $(this).addClass('pill-inverse');
      })
      .mouseleave(function () {
        $(this).removeClass('pill-inverse');
      });

      function getBuildOptions() {
        let build_options = {
          'name_en': $('#name_en').val(),
          'name_tw': $('#name_tw').val(),
          'columns': [],
          'features': []
        };

        $('#column_wrapper tr:not(.hide)').each(function (index, row) {
          build_options.columns.push({
            'column_name': $(row).find('.column_name').val(),
            'comment':     $(row).find('.comment').val(),
            'mixin':       $(row).find('.mixin').val(),
            'data_type':   $(row).find('.data_type').val()
          });
        });

        return build_options;
      }

      $('#submit').click(function () {
        buildAllItems();
      });
      $('#destroy').click(removeAllBuildedItems);

      $('#btn-add').click(cloneNewColumn);
      $(document).on('click', '.btn-delete', function () {
        //- let input_name = $(this).closest('tr').find('.del-name').find('input').val();
        //- let sure_to_delete = confirm('確定要刪除' + input_name + '嗎？');
        let sure_to_delete = true;
        if (sure_to_delete) $(this).closest('tr').remove();
      });
    </script>
  </body>
</html>
