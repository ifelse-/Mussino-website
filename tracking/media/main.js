
/* ----- Google maps */
var map = null,
    markers = null,
    markers_icon = null,
    center_global = [30, 10, 2],
    center_us = [38, -92, 4],
    center_eu = [48, 20, 4],
    custom_icon = null; // [16, 16, 'media/icon_marker.png']

// map initialization
function create_map(el) {
  map = new google.maps.Map2(el);
  map.enableDragging();
  map.enableContinuousZoom();
  map.enableScrollWheelZoom();
  map.addControl(new GLargeMapControl3D());
  map.addControl(new GMapTypeControl());
  //map.addControl(new GOverviewMapControl());
  var p = window['center_' + (window.region || 'global')];
  set_view(p);
}
function set_view(p) {
  map.setCenter(new google.maps.LatLng(p[0], p[1]), p[2]);
  return false;
}

google.setOnLoadCallback(function() {
  var el = document.getElementById("map");
  if (el)
    create_map(el);
});

// map update callback
function modify_markers(ins, del) {
  var initial = (markers == null);
  if (initial) {
    markers = {};
    markers_icon = new GIcon(G_DEFAULT_ICON);
    markers_icon.shadowSize = new GSize(0, 0);
    if (window.custom_icon) {
      var a = custom_icon, w = a[0], h = a[1];
      markers_icon.image = a[2];
      markers_icon.iconSize = new GSize(w, h);
      markers_icon.iconAnchor = new GPoint(w >> 1, h);
    }
  }
  $.each(ins, function(k, rec) {
    if (!rec.location) return;
    var loc = rec.location,
        pos = new GLatLng(loc.latitude, loc.longitude),
        opt = { title: loc.city + ' ' + rec.ip, icon: markers_icon, hide: !initial },
        marker = new GMarker(pos, opt);
    map.addOverlay(marker);
    markers[rec.hash] = marker;
    if (marker.isHidden())
      setTimeout(function() { animate_on(marker) }, 1);
  });
  $.each(del, function(k, id) {
    animate_off(markers[id]);
    delete markers[id];
  });
}

// animation hack
var anim_duration = 1000,
    anim_getter = function(m) { return m.V[0] };
function animate_on(m) {
  $(anim_getter(m))
    .css({ opacity: 0, visibility: 'visible' })
    .animate({ opacity: 1 }, anim_duration, function() { m.show() });
}
function animate_off(m) {
  if (!m) return;
  $(anim_getter(m))
    .animate({ opacity: 0 }, anim_duration, function() { map.removeOverlay(m) });
}

/* ----- Grid update */
function load_update() {
  $.ajax({
    url: 'ajax/visitors.php',
    cache: false,
    dataType: 'json',
    success: function(data) {
      var body = $('#grid tbody'), ref = {},
          ins = [], del = [], uid = 0, i;
      $('tr', body).each(function() {
        ref[this.id || ++uid] = this;
      });
      for (i = 0; i < data.length; i++) {
        var rec = data[i], row = ref[rec.hash],
            list = rec.visits, last = list.length - 1;
        // create row
        if (!row) {
          var cc = rec.location && rec.location.country_code.toLowerCase();
          row = $('<tr>').html(
            '<td class="number"></td>' +
            '<td class="info">' +
            '  <div class="country '+cc+'" style="'+(cc ? sprite_country(cc) : '')+'"' +
            '       title="'+(cc ? rec.location.country_name : '(local)')+'"></div>' +
            '  <div class="agent '+rec.browser+'" title="'+rec.agent+'"></div>' +
            '</td>' +
            '<td class="ip">'+rec.ip+'</td>' +
            '<td class="user">'+rec.user+'</td>' +
            '<td class="page"></td>' +
            '<td class="time"></td>' +
            '<td class="duration"></td>' +
            '<td class="trace"></td>'
          ).attr('id', rec.hash).prependTo(body);
          ins.push(rec);
        }
        // update row
        var dA = parse_date(list[0]), tA = dA.getTime(),
            dB = parse_date(list[last]), tB = dB.getTime(),
            mins = Math.floor((tB - tA) / 6e4),
            mins_str = mins ? mins + ' minute' + (mins > 1 ? 's' : '') : '&lt; 1 minute',
            link = '<a href="ajax/raw.php?uid=#" target="_blank">view</a>';
        $('.page', row).html(list[last].replace(/^\S+ \S+ /, ''));
        $('.time', row).html(format_time(dB));
        $('.duration', row).html(tA != tB ? mins_str : '');
        $('.trace', row).html(list.length + ' ' + link.replace('#', rec.hash));
        delete ref[rec.hash];
      }
      for (i in ref) {
        $(ref[i]).remove();
        del.push(i);
      }
      if (ins.length || del.length)
        $('tr', body).each(function(k) {
          this.firstChild.innerHTML = (k + 1) + '.';
        });
      if (map)
        modify_markers(ins, del);
    },
    complete: function() {
      setTimeout(load_update, reload_time * 1000);
    }
  });
}
jQuery(load_update);

// helper functions
function sprite_country(cc) {
  var base = 'a'.charCodeAt(0) - 1,
      sx = 16, px = cc.charCodeAt(0) - base,
      sy = 11, py = cc.charCodeAt(1) - base;
  return 'background-position: -'+(px * sx)+'px -'+(py * sy)+'px;';
}

function parse_date(str) {
  var m = /^(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})/.exec(str),
      d = new Date(m[1], m[2] - 1, m[3], m[4], m[5], m[6]);
  d.setTime(d.getTime() - d.getTimezoneOffset() * 6e4);
  return d;
}

function format_time(inst) {
  return pad(inst.getHours()) + ':' + pad(inst.getMinutes()) + ':' + pad(inst.getSeconds());
}
function pad(n) {
  return (n < 10 ? '0' : '') + n;
}

/* ----- GeoIP download */
jQuery(function() {
  var loading = false;
  $('.download button').click(function() {
    if (loading) return;
    loading = true;
    $.ajax({
      url: 'ajax/download.php',
      cache: false,
      timeout: 600 * 1000,
      success: function(text) {
        if (text == 'OK') return location.reload();
        $('<div>').addClass('warning').appendTo('.setup')
          .html('Download error:<br/>' + text.replace(/^<br\s*\/?>/, ''));
      },
      complete: function() {
        loading = false;
      }
    });
    fetch_progress();
  });

  function fetch_progress() {
    $.ajax({
      url: 'ajax/download_progress.php',
      cache: false,
      success: function(text) {
        if (loading) setTimeout(fetch_progress, 50);
        var a = text.split(' '),
            size = parseInt(a[0]), total = parseInt(a[1]);
        if (size && total)
          $('.download .progress span').width(Math.floor(100 * size / total) + '%');
      }
    });
  }
});
