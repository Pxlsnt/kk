<?php?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kritsana Tools — ร้านกฤษณะการช่าง</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;700&family=Prompt:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0f172a; --bg-soft:#111827; --card:rgba(255,255,255,0.06);
      --border:rgba(255,255,255,0.18); --text:#e5e7eb; --muted:#9ca3af;
      --brand:#6366f1; --brand-2:#22d3ee; --accent:#10b981; --danger:#ef4444;
    }
    *{box-sizing:border-box} html,body{height:100%}
    body{
      margin:0;
      font-family:'Kanit','Prompt',ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans Thai,"Helvetica Neue",Arial,"Apple Color Emoji","Segoe UI Emoji";
      color:var(--text);
      background:
        radial-gradient(1200px 600px at 10% -10%, rgba(99,102,241,0.15), transparent 50%),
        radial-gradient(1000px 500px at 100% 0%, rgba(34,211,238,0.12), transparent 50%),
        linear-gradient(180deg, var(--bg), var(--bg-soft));
      min-height:100%;
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }
    a{color:var(--brand-2); text-decoration:none} a:hover{text-decoration:underline}
    input,select,textarea{
      width:100%; padding:.7rem .9rem; border-radius:.75rem; border:1px solid var(--border);
      background:rgba(255,255,255,0.05); color:var(--text); outline:none;
    }
    button,.btn,input[type=submit]{
      border:1px solid var(--border);
      background:linear-gradient(180deg, rgba(99,102,241,0.2), rgba(34,211,238,0.18));
      color:#fff; padding:.75rem 1rem; border-radius:.75rem; cursor:pointer;
      transition:transform .15s ease, box-shadow .2s ease, background .2s ease;
    }
    button:hover,.btn:hover,input[type=submit]:hover{transform:translateY(-1px); box-shadow:0 8px 24px rgba(99,102,241,.25)}
    button:active,.btn:active,input[type=submit]:active{transform:translateY(0)}
    .badge{font-size:.8rem; border:1px solid var(--border); padding:.2rem .45rem; border-radius:.5rem; color:var(--muted)}
    .container{max-width:1200px; margin:0 auto; padding:1.25rem}
  
    .header{
      display:flex; align-items:center; justify-content:space-between; gap:1rem;
      padding:1rem 1.25rem; position:sticky; top:0; z-index:50;
      background:rgba(17,24,39,0.75); border-bottom:1px solid var(--border);
      backdrop-filter:blur(8px);
    }
    .logo{font-weight:800; letter-spacing:.5px}
    .brand{display:inline-flex; align-items:center; gap:.55rem}
    .brand-dot{width:.6rem; height:.6rem; background:linear-gradient(45deg, var(--brand), var(--brand-2)); border-radius:999px; box-shadow:0 0 18px rgba(34,211,238,.6)}
    .search{flex:1; max-width:600px; display:flex; gap:.5rem} .search input{flex:1}
    .header nav a.category{border:1px solid var(--border); padding:.5rem .8rem; border-radius:.6rem; display:inline-block}
    .header nav a.category:hover{background:rgba(255,255,255,.06)}
    .layout{display:grid; grid-template-columns:220px 1fr; gap:1.25rem}
    .sidebar{border:1px solid var(--border); background:var(--card); border-radius:1rem; padding:1rem}
    .category{display:block; padding:.5rem .75rem; border-radius:.5rem}
    .category:hover{background:rgba(255,255,255,.06)}
    .grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:1rem}
    .card-prod{
      border:1px solid var(--border);
      background:linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      border-radius:1rem; overflow:hidden; display:flex; flex-direction:column;
      transition:transform .15s ease, box-shadow .2s ease;
    }
    .card-prod:hover{transform:translateY(-2px); box-shadow:0 12px 28px rgba(0,0,0,.25)}
    .card-prod img{aspect-ratio:4/3; width:100%; object-fit:cover}
    .card-body{padding:.9rem}
    .card-title{font-weight:700; margin:0 0 .25rem}
    .price{font-weight:700}
    .card-actions{display:flex; justify-content:space-between; align-items:center; padding:.9rem; border-top:1px solid var(--border)}
    .footer{margin-top:2rem; padding:1.2rem; text-align:center; color:var(--muted); border-top:1px solid var(--border)}
    @media (max-width:900px){ .layout{grid-template-columns:1fr} }
  </style>
</head>
<body>
  <?php $shopName = "Phuchiss Tools"; $shopSub = "ร้านกฤษณะการช่าง"; ?>
  <header class="header">
    <div class="logo brand"><span class="brand-dot"></span> <?php echo $shopName; ?></div>
    <div class="search">
      <input type="text" placeholder="ค้นหาสินค้า เช่น ไขควง ประแจ คีม...">
      <button>ค้นหา</button>
    </div>
    <nav>
      <a href="login.php" class="category">เข้าสู่ระบบ</a>
      <a href="registeer.php" class="category">สมัครสมาชิก</a>
    </nav>
  </header>

  <div class="container">
    <div class="layout">
      <aside class="sidebar">
        <h3 style="margin-top:0">หมวดหมู่</h3>
        <a class="category" href="#">เครื่องมือช่าง</a>
        <a class="category" href="#">อุปกรณ์ไฟฟ้า</a>
        <a class="category" href="#">คอมพิวเตอร์</a>
        <a class="category" href="#">อุปกรณ์สำนักงาน</a>
        <a class="category" href="#">เซฟตี้/ความปลอดภัย</a>
      </aside>

      <main>
        <div class="grid">
          <?php
            // รายการสินค้าเดโม่
            $products = [
              ["name"=>"ชุดไขควงแกนแม่เหล็ก 8in1", "price"=>229, "img"=>"", "tag"=>"เครื่องมือ"],
              ["name"=>"ประแจเลื่อน 10 นิ้ว (เหล็ก CR-V)", "price"=>189, "img"=>"", "tag"=>"เครื่องมือ"],
              ["name"=>"คีมปากจิ้งจก 6 นิ้ว", "price"=>149, "img"=>"", "tag"=>"เครื่องมือ"],
              ["name"=>"ค้อนช่างไม้ ด้ามไฟเบอร์ 16oz", "price"=>259, "img"=>"", "tag"=>"เครื่องมือ"],
              ["name"=>"ไขควงเช็คไฟ ด้ามกันไฟรั่ว", "price"=>79, "img"=>"", "tag"=>"ไฟฟ้า"],
              ["name"=>"ปลั๊กพ่วง 4 ช่อง สาย 3 เมตร", "price"=>269, "img"=>"", "tag"=>"ไฟฟ้า"],
              ["name"=>"ไฟฉายแรงสูง ชาร์จ USB", "price"=>239, "img"=>"", "tag"=>"ไฟฟ้า"],
              ["name"=>"เมาส์ไร้สาย 2.4G", "price"=>219, "img"=>"", "tag"=>"คอมพิวเตอร์"],
              ["name"=>"คีย์บอร์ดมีสาย ขนาดเต็ม", "price"=>299, "img"=>"", "tag"=>"คอมพิวเตอร์"],
              ["name"=>"หูฟังครอบหู มีไมค์", "price"=>329, "img"=>"", "tag"=>"คอมพิวเตอร์"],
              ["name"=>"แฟ้มสันกว้าง A4", "price"=>49, "img"=>"", "tag"=>"สำนักงาน"],
              ["name"=>"แม็กหนีบกระดาษ + ลวด", "price"=>59, "img"=>"", "tag"=>"สำนักงาน"],
              ["name"=>"เทปกาวใส 2 ม้วน + แท่นตัด", "price"=>69, "img"=>"", "tag"=>"สำนักงาน"],
              ["name"=>"ถุงมือกันบาด ระดับ 5", "price"=>129, "img"=>"", "tag"=>"เซฟตี้"],
              ["name"=>"แว่นตานิรภัย เคลือบกันฝ้า", "price"=>99, "img"=>"", "tag"=>"เซฟตี้"],
            ];
            foreach($products as $p):
          ?>
          <div class="card-prod">
            <img src="<?php echo $p['img']; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-body">
              <div class="badge"><?php echo $p['tag']; ?></div>
              <h4 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h4>
              <div class="price"><?php echo number_format($p['price']); ?> ฿</div>
            </div>
            <div class="card-actions">
              <button>หยิบใส่ตะกร้า</button>
              <a href="#" class="category">รายละเอียด</a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </main>
    </div>

    <div class="footer">© <?php echo date('Y'); ?> <?php echo $shopName; ?> — <?php echo $shopSub; ?></div>
  </div>
</body>
</html>
