@foreach ($log as $item)
<div>
    <i class="fas fa-user {{$item->tb_ulog == 'direktur' ? 'bg-danger' : 'bg-warning'}}"></i>
    <div class="timeline-item">
      <span class="time"><i class="fas fa-clock"></i> {{$item->created_at}}</span>
      <h3 class="timeline-header"><a href="#">{{strtoupper($item->tb_ulog)}}</a></h3>
      <div class="timeline-body">
        <p>{{$item->ur_logv}}</p>
      </div>
      <div class="timeline-footer">
        <a href=""></a>
      </div>
    </div>
</div>
@endforeach