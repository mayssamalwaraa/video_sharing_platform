@extends('theme.default')

@section('heading')
الفيديوهات الأكثر مشاهدة
@endsection

@section('content')
<hr>
<div class="row">
    <div class="col-md-12">
        <table id="videos-table" class="table table-stribed text-right" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>اسم الفيديو</th>
                    <th>اسم القناة</th>
                    <th>عدد المشاهدات</th>
                    <th>تاريخ النشر</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($mostViewedVideos as $view)
                    <tr>
                        <td><a href="/videos/{{$view->video->id}}">{{ $view->video->title }}</a></td>
                        <td>{{ $view->user->name}}</td>
                        <td>{{ $view->views_number }}</td>
                        <td>
                            <p>{{ $view->video->created_at }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div>
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>
@endsection

@section('script')

<script>
    var names = <?php echo $videoNames; ?>;
    var totalViews = <?php echo $videoViews; ?>;
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                label: 'القنوات الأكثر مشاهدة',
                data: totalViews
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection