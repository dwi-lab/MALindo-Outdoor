new Highcharts.Chart({
  chart: {
    renderTo: 'chart-guru',
    type: 'line',
  },
  title: {
    text: 'Grafik Presensi Guru',
    x: -20
  },
  subtitle: {
    text: '',
    x: -20
  },
  xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
  },
  yAxis: {
    title: {
      text: 'Jumlah (Orang)'
    }
  },
  series: [{
    name: 'Hadir',
    data: <?php echo json_encode($grafikhadir); ?>
  },{
    name: 'Sakit',
    data: <?php echo json_encode($grafiksakit); ?>
  },{
    name: 'Izin',
    data: <?php echo json_encode($grafikizin); ?>
  },{
    name: 'Cuti',
    data: <?php echo json_encode($grafikcuti); ?>
  }]
});