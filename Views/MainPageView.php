<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <? include "topbar_header.php"; ?>

    <? include "left_sidebar.php"; ?>

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper  p-t-30">

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- начало wrapper-а обеих колонок -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- ============================================================== -->
                <!-- начало левой колонки-->
                <!-- ============================================================== -->
                <div class="col-lg-8 col-xlg-9">
                    <!-- ============================================================== -->
                    <!--начало карты-->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-30">
                        <div class="col-12">
                            <div id="main-page-map" class="card margin-bottom-0">
                                <div class="card-body" id="mapid"></div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!--конец карты-->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!--начало списка референдумов-->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-30">
                        <div class="col-12">
                            <h2 class="margin-bottom-20 mp-section-header">Последние интернет-референдумы</h2>


                            <div class="row">

                            <? foreach ($data['freshReferendums'] as $referendumData): ?>

                                <div class=" col-3">
                                    <div class="card card-inverse stat-card">
                                        <div class="card-body">
                                            <div class="problem-type margin-bottom-20"><?=htmlspecialchars(mb_strtoupper($referendumData['problem_name']))?></div>

                                            <div class="my-card-title"><?=htmlspecialchars($referendumData['subject'])?></div>

                                            <div class="margin-bottom-20"><img src="<?=$referendumData['thumbnail']?>" width="240" height="135"></div>

                                            <div>
                                                <a  href="/referendum/show/<?=$referendumData['id']?>" class="btn btn-success waves-effect waves-light" type="button">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <? endforeach; ?>

                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!--конец списка референдумов-->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!--начало списка обращений-->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-30">
                        <div class="col-12">
                            <h2 class="margin-bottom-20  mp-section-header">Последние обращения</h2>

                            <div class="row">
                            <? foreach ($data['freshAppeals'] as $appealData): ?>

                                <div class=" col-3">
                                    <div class="card card-inverse stat-card">
                                        <div class="card-body">
                                            <div class="problem-type margin-bottom-20"><?=htmlspecialchars(mb_strtoupper($appealData['problem_name']))?></div>

                                            <div class="my-card-title"><?=htmlspecialchars($appealData['subject'])?></div>

                                            <div class="margin-bottom-20"><?=htmlspecialchars($appealData['message'])?></div>

                                            <div>
                                                <a  href="/appeal/show/<?=$appealData['id']?>" class="btn btn-success waves-effect waves-light" type="button">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <? endforeach; ?>
                            </div>

                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!--конец списка обращений-->
                    <!-- ============================================================== -->


                </div>
                <!-- ============================================================== -->
                <!-- конец левой колонки-->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- начало правой колонки-->
                <!-- ============================================================== -->
                <div class="col-lg-4 col-xlg-3">
                    <!-- ============================================================== -->
                    <!-- начало ушка с данными о референдумах -->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-20">
                        <div class="col-12">
                            <div class="card card-inverse card-info stat-card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h1 class="text-white"><i class="ti-pie-chart"></i></h1></div>
                                        <div>
                                            <h3 class="card-title">Интернет-референдумы</h3>
                                            <h6 class="card-subtitle">с февраля 2019</h6> </div>
                                    </div>
                                    <div class="row stat-btns">
                                        <div class="col-4 align-self-center text-center " data-request="/referendum/search?time=all">
                                            <h2 class="font-light text-white"><?=$data['referendumsStats']['totally_created'] ?></h2>
                                            <sup class="font-light text-white ">за все время</sup>
                                        </div>
                                        <div class="col-4 align-self-center  text-center" data-request="/referendum/search?time=till_new_year">
                                            <h2 class="font-light text-white"><?=$data['referendumsStats']['this_year_created'] ?></h2>
                                            <sup class="font-light text-white">с начала года</sup>
                                        </div>
                                        <div class="col-4 align-self-center  text-center" data-request="/referendum/search?status=active">
                                            <h2 class="font-light text-white"><?=$data['referendumsStats']['currently_active'] ?></h2>
                                            <sup class="font-light text-white">активных</sup>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- конец ушка с данными о референдумах -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- начало ушка с данными об обращениях -->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-20">
                        <div class="col-12">
                            <div class="card card-inverse card-danger stat-card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="m-r-20 align-self-center">
                                            <h1 class="text-white"><i class="ti-light-bulb"></i></h1></div>
                                        <div>
                                            <h3 class="card-title">Обращения граждан</h3>
                                            <h6 class="card-subtitle">с августа 2019</h6> </div>
                                    </div>
                                    <div class="row stat-btns" style="padding-top:4px">
                                        <div class="col-4 align-self-center text-center " data-request="/appeal/search?time=all&limit=50">
                                            <h2 class="font-light text-white"><?=$data['appealsStats']['totally_created'] ?></h2>
                                            <sup class="font-light text-white ">за все время</sup>
                                        </div>
                                        <div class="col-4 align-self-center  text-center" data-request="/appeal/search?time=till_new_year&limit=50">
                                            <h2 class="font-light text-white"><?=$data['appealsStats']['this_year_created'] ?></h2>
                                            <sup class="font-light text-white">с начала года</sup>
                                        </div>
                                        <div class="col-4 align-self-center  text-center" data-request="/appeal/search?status=active&limit=50">
                                            <h2 class="font-light text-white"><?=$data['appealsStats']['currently_active'] ?></h2>
                                            <sup class="font-light text-white">активных</sup>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- конец ушка с данными об обращениях -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- начало ушка с самыми активными пользователями -->
                    <!-- ============================================================== -->
                    <div class="row margin-bottom-20">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Самые активные пользователи</h4>

                                    <div class="table-responsive">
                                        <table class="table stylish-table">
                                            <tbody>

                                            <? foreach ($data['awardedUsers'] as $awardedUser): ?>
                                            <tr>
                                                <td style="width:50px;"><a href="/user/show/profile/<?=$awardedUser['id']?>"><span class="round"><img src="<?=$awardedUser['avatar']?>" alt="<?=htmlspecialchars($awardedUser['fio']) ?>" width="50" height="50"></span></a></td>
                                                <td>
                                                    <a href="/user/profile/<?=$awardedUser['id']?>">
                                                        <h6><?=$awardedUser['fio']?></h6>
                                                        <small class="text-muted"><?=$awardedUser['award']?></small>
                                                    </a>
                                                </td>
                                            </tr>

                                            <? endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- конец ушка с самыми активными пользователями -->
                    <!-- ============================================================== -->

                    <!-- навешиваем в ушках со статистиками обработчики клика-->
                    <script>
                        window.addEventListener('load', function() {
                            const map = L.map('mapid').setView([57.341715, 36.045027], 7);
                            const appealMarkers = [];
                            const referendumMarkers = [];

                            //Extend the Default marker class
                            var RedIcon = L.Icon.Default.extend({
                                options: {
                                    iconUrl: 'marker-icon-red.png'
                                }
                            });
                            var redIcon = new RedIcon();

                            //Extend the Default marker class
                            var BlueIcon = L.Icon.Default.extend({
                                options: {
                                    iconUrl: 'marker-icon-blue.png'
                                }
                            });
                            var blueIcon = new BlueIcon();

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            $('.row.stat-btns').each(function(groupIdx, groupElem) {
                                $(groupElem).children().each(function(btnIdx, btnElem) {

                                    $(btnElem).click(function() {
                                        if (groupIdx == 0) {
                                            referendumMarkers.forEach(function(tempMarker) {
                                                map.removeLayer(tempMarker);
                                            });
                                        }
                                        else {
                                            appealMarkers.forEach(function(tempMarker) {
                                                map.removeLayer(tempMarker);
                                            });
                                        }


                                        if ($(this).hasClass('active-filter-btn')) {
                                            $(this).removeClass('active-filter-btn');
                                            return;
                                        }

                                        $.toast({
                                            heading: 'Уведомление',
                                            text: 'Будет загружено не более 50 маркеров на карту',
                                            textColor: '#fff',
                                            position: 'bottom-right',
                                            loaderBg: '#335577',
                                            icon: 'info',
                                            hideAfter: 2500
                                        });

                                        $(groupElem).find('.active-filter-btn').removeClass('active-filter-btn');
                                        $(this).addClass('active-filter-btn');

                                        const request = $(this).data("request");

                                        $.ajax({
                                            url: request,
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(data){

                                                data.forEach(function(elem) {
                                                    let event_date = '';

                                                    event_date = (groupIdx == 0) ? elem.time_start : elem.time_created;
                                                    event_date = event_date.split(" ")[0];
                                                    const popupHTML =
                                                        `<h4>` + elem.subject + `</h4>` +
                                                        `<span style="font-size: 10px; background-color: #aa3333; padding: 3px; color: #fff">` + event_date + `</span>` +
                                                        `<div style="margin: 8px 0; max-height: 200px;overflow: hidden">` + elem.message + `</div>` +
                                                        `<i>` + elem.full_address + `</i>`;

                                                    const markerIcon = (groupIdx == 0) ? blueIcon : redIcon;
                                                    const marker = L.marker([elem.lat, elem.lon], {icon: markerIcon}).addTo(map);
                                                    marker.bindPopup(popupHTML);
                                                    (groupIdx == 0) ? referendumMarkers.push(marker) : appealMarkers.push(marker);
                                                });
                                            },
                                            error: function() {
                                                $.toast({
                                                    heading: 'Ошибка получения данных',
                                                    text: 'Не удалось подгрузить с сервера данные маркеров для нанесения на карту',
                                                    position: 'top-right',
                                                    loaderBg:'#ff6849',
                                                    icon: 'error',
                                                    hideAfter: 2500
                                                });
                                            }
                                        });

                                    });

                                    if (btnIdx === 2) {
                                        $(btnElem).click();
                                    }
                                });
                            });
                        });
                    </script>


                </div>
                <!-- ============================================================== -->
                <!-- конец правой колонки-->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- конец wrapper-а обеих колонок -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

        <? include "common_footer.php"; ?>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->