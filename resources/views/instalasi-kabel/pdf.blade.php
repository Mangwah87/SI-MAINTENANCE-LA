<?php
$logoFilePath = public_path('images/Lintasarta_Logo_Logogram.png');
?>
<!DOCTYPE html> 
<html lang="id">
<head>
<meta charset="UTF-8">
<title>PM Instalasi Kabel - {{ $header->no_dokumen ?? 'Report' }}</title>
<style>
  @page { size:Letter; margin: 1.23cm 1.63cm 1.54cm 2.54cm;; }
  body{ font-family: Arial, sans-serif; font-size:10pt; color:#000; margin:0; padding:0; }
  table{ border-collapse:collapse; width:100%; margin-bottom:5px; table-layout:fixed; }

  /* ===== MAIN CHECKLIST TABLE ===== */
  .main-table th, .main-table td{
    border: .75pt solid #000;
    padding: 1px 3px;
    vertical-align: top;
    font-size: 7pt;
    word-wrap: break-word;
  }
  .main-table th{ text-align:left; font-weight:bold; background:#e6e6e6; }

  /* Baris kategori & subkategori */
  .row-cat{ background:#EFEFEF; font-weight:bold; padding:6px 8px !important; }
  .row-sub{ background:#F7F7F7; font-weight:bold; padding:5px 8px 5px 22px !important; }

  .text-center{ text-align:center; }
  .no-border{ border:none !important; }
  .avoid-break{ page-break-inside: avoid; }
  /* Keep blocks together and avoid page breaks around them */
  .avoid-break{ page-break-before: avoid; page-break-after: avoid; break-inside: avoid; }

  /* Header kiri-kanan */
  .pelaksana-table th, .pelaksana-table td{ border:1px solid #000; padding:3px 5px; text-align:center; }
  .sign-col{ height:45px; }
</style>
</head>
<body>

{{-- HEADER DOKUMEN --}}
<div class="avoid-break" style="margin-bottom:5px;">
  <table style="font-size:8pt;">
    <tr>
      <td style="width:35%; border:1px solid #000; padding:0;">
        <table style="font-size:7pt;">
          <tr>
            <td style="width:25%; border:none; border-bottom:1px solid #000; padding:1px 3px;">No. Dok.</td>
            <td style="width:5%; text-align:center; border:none; border-bottom:1px solid #000;">:</td>
            <td style="width:70%; border:none; border-bottom:1px solid #000; padding:1px 3px;" colspan="2">{{ $header->no_dokumen ?? 'FM-LAP-D2-SOP-003-012' }}</td>
          </tr>
          <tr>
            <td style="border:none; border-bottom:1px solid #000; padding:1px 3px;">Versi</td>
            <td style="text-align:center; border:none; border-bottom:1px solid #000;">:</td>
            <td style="border:none; border-bottom:1px solid #000; padding:1px 3px;" colspan="2">1.0</td>
          </tr>
          <tr>
            <td style="border:none; border-bottom:1px solid #000; padding:1px 3px;">Hal</td>
            <td style="text-align:center; border:none; border-bottom:1px solid #000;">:</td>
            <td style="border:none; border-bottom:1px solid #000; padding:1px 3px;" colspan="2">1 dari 2</td>
          </tr>
          <tr>
            <td style="border:none; padding:1px 3px;">Label</td>
            <td style="text-align:center; border:none;">:</td>
            <td style="border:none; padding:1px 3px;" colspan="2">Internal</td>
          </tr>
        </table>
      </td>
      <td style="width:45%; border:1px solid #000; border-left:none; text-align:center; padding:5px;">
        <span style="font-weight:bold; font-size:12pt;">Formulir</span><br>
        <span style="font-weight:bold; font-size:10pt;">Preventive Maintenance Instalasi Kabel dan Panel Distribusi</span>
      </td>
      <td style="width:15%; border:1px solid #000; border-left:none; text-align:center; padding:5px;">
        @if (file_exists($logoFilePath))
          <img src="{{ $logoFilePath }}" style="max-width:90%; max-height:50px;" alt="Logo">
        @else
          <div style="width:50px;height:50px;background:#ccc;margin:0 auto;line-height:50px;font-size:8pt;border:1px solid #999;">NO LOGO</div>
        @endif
      </td>
    </tr>
  </table>
</div>

{{-- INFO UMUM + CHECKLIST WRAPPER (keep together) --}}
<div class="avoid-break">
<table style="margin-bottom:3px;">
  <tr><td width="15%">Location</td><td width="85%">: {{ $header->location }}</td></tr>
  <tr><td>Date / time</td><td>: {{ $header->date_time?->format('d M Y / H:i') }}</td></tr>
  <tr><td>Brand / Type</td><td>: {{ $header->brand_type ?? '-' }}</td></tr>
  <tr><td>Reg. Number</td><td>: {{ $header->reg_number ?? '-' }}</td></tr>
  <tr><td>S/N</td><td>: {{ $header->serial_number ?? '-' }}</td></tr>
</table>

{{-- 3. TABEL CHECKLIST (struktur dipakukan agar persis template) --}}
<div class="avoid-break">
  <table class="main-table">
    <colgroup>
      <col style="width:5%;">   <!-- No. -->
      <col style="width:40%;">  <!-- Descriptions -->
      <col style="width:20%;">  <!-- Result -->
      <col style="width:25%;">  <!-- Operational Standard -->
      <col style="width:10%;">  <!-- Status (OK/NOK) -->
    </colgroup>
    <thead>
      <tr>
        <th>No.</th>
        <th>Descriptions</th>
        <th>Result</th>
        <th>Operational Standard</th>
        <th>Status<br>(OK/NOK)</th>
      </tr>
    </thead>
    <tbody>
    @php
      // Kumpulkan semua detail ke satu koleksi datar
      $pool = collect();
      if(isset($groupedDetails) && count($groupedDetails)){
        foreach($groupedDetails as $g){ $pool = $pool->merge($g); }
      }
      if(isset($details) && count($details)){ $pool = collect($details); }
      if(isset($detailsWithPhotos) && $detailsWithPhotos->count()){ $pool = $pool->merge($detailsWithPhotos); }
      $pool = $pool->unique('id'); // cegah duplikat kalau ada

      // Normalizer utk pencocokan "longgar"
      $norm = function($s){
        $s = mb_strtolower((string)$s);
        $s = preg_replace('/\s+/', ' ', $s);
        $s = str_replace(['–','—','-'], '-', $s); // variasi dash
        return trim($s);
      };

      // Ambil item dari pool berdasarkan label (contains match, case-insensitive)
      $pick = function($label) use (&$pool, $norm){
        $key = $norm($label);
        $idx = $pool->search(function($it) use ($norm, $key){
          $d = $norm($it->item_description ?? '');
          return $d === $key || str_contains($d, $key);
        });
        if($idx !== false){
          $it = $pool->get($idx);
          $pool->forget($idx); // keluarkan supaya tidak dipakai dua kali
          return $it;
        }
        return null;
      };

      // Cek ketersediaan tanpa mengeluarkan dari pool (non-destruktif)
      $exists = function($label) use ($pool, $norm){
        $key = $norm($label);
        $idx = $pool->search(function($it) use ($norm, $key){
          $d = $norm($it->item_description ?? '');
          return $d === $key || str_contains($d, $key);
        });
        return $idx !== false;
      };
      $existsAny = function($labels) use ($exists){
        foreach($labels as $label){ if($exists($label)) return true; }
        return false;
      };

      // ======= STRUKTUR DIPAKUKAN SESUAI FORM =======
      $layout = [
        '1. Visual Check' => [
          null => [
            'Indicator Lamp',
            'Voltmeter & Ampere meter',
            'Arrester',
            'MCB Input UPS',
            'MCB Output UPS',
            'MCB Bypass',
          ],
        ],
        '2. Performance Measurement' => [
          'I. MCB Temperature' => [
            'Input UPS',
            'Output UPS',
            'Bypass UPS',
            'Load Rack',
            'Cooling unit ( AC )',
          ],
          'II. Cable Temperature' => [
            'Input UPS',
            'Output UPS',
            'Bypass UPS',
            'Load Rack',
            'Cooling unit ( AC )',
          ],
        ],
        '3. Performance Check' => [
          null => [
            'Maksure All Cable Connection',
            'Spare of MCB Load Rack',
            'Single Line Diagram',
          ],
        ],
      ];

      // Helper render satu baris item (jika tidak ketemu, baris kosong tetap dicetak)
      $renderItem = function($label, $letter, $indentClass) use ($pick){
        $item = $pick($label);
        if(!$item){ return false; } // jangan render baris kosong
        echo '<tr>';
        echo    '<td class="text-center">'.e($letter).'.</td>';
        echo    '<td class="'.e($indentClass).'">'.e($label).'</td>';
        echo    '<td class="text-center">'.e($item->result ?? '').'</td>';
        echo    '<td class="text-center">'.e($item->operational_standard ?? '').'</td>';
        $status = $item->status ?? '';
        echo    '<td class="text-center">'.($status === 'OK' ? 'OK' : ($status === 'NOK' ? 'NOK' : '')).'</td>';
        echo '</tr>';
        return true;
      };
    @endphp

    @foreach($layout as $catTitle => $subs)
      @php
        $catHasData = false;
        foreach($subs as $subTitleTmp => $labelsTmp){
          if($existsAny($labelsTmp)) { $catHasData = true; break; }
        }
      @endphp
      @if($catHasData)
      {{-- Baris Kategori --}}
      <tr><td colspan="5" class="row-cat">{{ $catTitle }}</td></tr>

      @foreach($subs as $subTitle => $labels)
        @if(!is_null($subTitle))
          @if($existsAny($labels))
            {{-- Baris Sub-Kategori --}}
            <tr><td colspan="5" class="row-sub">{{ $subTitle }}</td></tr>
            @php $letter = 'a'; @endphp
            @foreach($labels as $label)
              @php $printed = $renderItem($label, $letter, 'indent-a'); @endphp
              @if($printed) @php $letter++; @endphp @endif
            @endforeach
          @endif
        @else
          @php $letter = 'a'; @endphp
          @foreach($labels as $label)
            @php $printed = $renderItem($label, $letter, 'indent-a-nosub'); @endphp
            @if($printed) @php $letter++; @endphp @endif
          @endforeach
        @endif
      @endforeach
      @endif
    @endforeach
    </tbody>
  </table>

  <div style="font-size:8pt; margin-top:2px;">*) Choose the appropriate</div>
</div>
{{-- Close wrapper to keep INFO UMUM and TABLE on same page --}}
</div>
{{-- CATATAN --}}
    <strong style="text-decoration: underline;">Notes / additional informations :</strong>
    <div style="border:1px solid #000; min-height:55px; margin-top:5px;">
        </div>
</div>

<hr style="border: none; border-top: 1px solid #ccc; margin-top: 30px; margin-bottom: 5px;">
<div>
  <div style="font-size: 5px; color: #666; position: relative; margin-bottom: 5px;">
    <span style="color: #000;">©HakCipta PT. APLIKANUSA LINTASARTA, Indonesia</span>
  </div>
  <div style="font-size: 5px; color: #000; ">
    FM-LAP- D2-SOP-003-012 Formulir Preventive Maintenance Instalasi Kabel dan Panel Distribusi
  </div>
</div>

{{-- DOKUMENTASI FOTO (opsional) --}}
@if($detailsWithPhotos->count() > 0)
<div class="page-break">
  <div style="font-weight:bold; margin-top:15px; margin-bottom:2px;">DOKUMENTASI FOTO</div>
  <table style="border:none;">
    @php $chunks = $detailsWithPhotos->chunk(3); @endphp
    @foreach($chunks as $row)
      <tr>
        @foreach($row as $p)
          <td style="border:none; padding:5px; width:33.33%; text-align:center;">
            @php
              $path = isset($p->pdf_photo_public_path) && $p->pdf_photo_public_path
                    ? $p->pdf_photo_public_path
                    : public_path('storage/'.$p->photo_path);
            @endphp
            @if($path && file_exists($path))
              <img src="{{ $path }}" style="width:100%; max-height:200px; object-fit:contain; margin-bottom:5px;">
            @else
              <div style="height:180px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#999; font-size:8pt;">
                Foto Tidak Ditemukan!
              </div>
            @endif
            <div style="font-size:8pt; font-weight:bold; margin-top:3px;">{{ $p->item_description }} (Status: {{ $p->status }})</div>
          </td>
        @endforeach
        @for($i=$row->count(); $i<3; $i++) <td style="border:none;"></td> @endfor
      </tr>
    @endforeach
  </table>
</div>
@endif

{{-- TANDA TANGAN --}}
<div class="avoid-break" style="margin-top:10px;">
  <div style="text-align:right; font-size:9pt;">
    {{ $header->location ?? '-' }}, {{ $carbon->parse($header->date_time)->translatedFormat('d F Y') }}
  </div>
  <table class="pelaksana-table">
    <thead>
      <tr>
        @foreach($header->signatures->take(3) as $s)
          <th style="width:33.33%;">{{ $s->role }}</th>
        @endforeach
        @for ($i=$header->signatures->count(); $i<3; $i++) <th style="width:33.33%;"></th> @endfor
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach($header->signatures->take(3) as $s) <td class="sign-col"></td> @endforeach
        @for ($i=$header->signatures->count(); $i<3; $i++) <td class="sign-col"></td> @endfor
      </tr>
      <tr>
        @foreach($header->signatures->take(3) as $s) <td>( {{ $s->name ?? '.......................' }} )</td> @endforeach
        @for ($i=$header->signatures->count(); $i<3; $i++) <td></td> @endfor
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
