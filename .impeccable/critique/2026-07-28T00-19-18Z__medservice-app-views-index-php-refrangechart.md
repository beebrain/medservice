---
target: Result Card 2 graphs (refRangeChart + mcvRdwScatter)
total_score: 25
p0_count: 0
p1_count: 3
timestamp: 2026-07-28T00-19-18Z
slug: medservice-app-views-index-php-refrangechart
---
# Impeccable Critique — Result Card 2 Graphs (`refRangeChart` + `mcvRdwScatter`)

**Target:** `Medservice/app/Views/index.php` — Result Card 2 ใน modal แปลผล CBC  
**Context:** เครื่องมือคัดกรองโลหิตจาง/ธาลัสซีเมียในเด็ก สำหรับบุคลากรทางการแพทย์  
**Assessed:** 2026-07-28 (local + browser @ 390px / desktop)

---

## Design Health Score

| # | Heuristic | Score | Key Issue |
|---|-----------|-------|-----------|
| 1 | Visibility of System Status | 3 | สถานะแสดงด้วยสี+ข้อความ แต่กราฟไม่มี state loading / empty |
| 2 | Match System / Real World | 2 | ศัพท์ TT/IDA/MCV ไม่มีคำอธิบายไทยสำหรับผู้ใช้ใหม่ |
| 3 | User Control and Freedom | 3 | ปิด modal ได้ แต่ไม่มีทางสลับมุมมอง (ตาราง vs กราฟ) |
| 4 | Consistency and Standards | 2 | ธีมม่วงของ Card 2 vs แถบเขียวของกราฟ — สองภาษ visual |
| 5 | Error Prevention | 3 | n/a (display-only) |
| 6 | Recognition Rather Than Recall | 3 | มี legend + header บน desktop; mobile ซ่อน header |
| 7 | Flexibility and Efficiency | 2 | ไม่มี zoom, export, หรือ table view สำหรับ power user |
| 8 | Aesthetic and Minimalist Design | 2 | โหลด cognitive สูง: 7 แถว + scatter + 3 indices + summary |
| 9 | Error Recovery | 3 | n/a |
| 10 | Help and Documentation | 2 | footnote 10px เดียว; scatter cutoff ไม่ объяс |
| **Total** | | **25/40** | **Acceptable — ต้องปรับก่อนใช้จริงใน รพ.** |

**Cognitive Load:** 4/8 checklist failures (moderate–high). 7 พารามิเตอร์ + scatter + 3 ดัชนี = เกิน working memory ในจุดเดียว

---

## Anti-Patterns Verdict

**LLM assessment:** กราฟดีขึ้นจากรอบก่อน (มีชื่อตัวชี้วัด + badge ช่วงปกติ) แต่ยังอ่านว่า "AI ทำ" ได้ — purple card stack, nested cards ใน modal, ตัวอักษร 9–10px ทั่วกราฟ, และ scatter แบบ DIY ที่ไม่มี axis title ชัด

**Deterministic scan (CLI):** 12 findings ใน `index.php` — ที่เกี่ยวกับกราฟโดยตรง:
- `text-purple-600` บน heading Card 2 (line ~398) — AI color palette
- `nested-cards` — Card 2 ซ้อน card ย่อย 7 แถว + scatter wrapper

**Browser detect (live):** Injection สำเร็จ. Findings ที่กระทบกราฟ:
- **low-contrast:** `text-gray-400` 2.5:1 บนขาว (unit labels, footnote)
- **low-contrast:** `text-amber-600` 3.2:1 (ค่าต่ำกว่าช่วง)
- **low-contrast:** `text-emerald-600` 3.8:1 (ค่าปกติ — ใกล้แต่ยังไม่ถึง 4.5:1)
- **low-contrast:** `#ffffff on #f97316` 2.8:1 (ป้าย IDA? บน scatter)
- **tiny-text:** body 10px หลายจุดในกราฟ
- **nested-cards:** 7 row cards + scatter card ซ้อนใน Result Card 2

---

## Overall Impression

การปรับรอบล่าสุดแก้ปัญหาใหญ่ของรอบแรก (ไม่มี label, จุดหาย) ได้ดี — ตอนนี้อ่าน **ช่วงปกติ** และ **ค่าคนไข้** แยกกันได้แล้ว แต่กราฟยังไม่พร้อมใช้ใน clinical flow: บนมือถือแคบเกินไป, contrast ไม่ผ่าน WCAG, และข้อมูลซ้อนกันมากเกินไปใน modal เดียว

**โอกาสใหญ่สุด:** ลด cognitive load — แยก "ตารางช่วงปกติ" กับ "กราฟตำแหน่ง" หรือย่อ scatter ให้เป็น secondary insight

---

## What's Working

1. **Badge ช่วงปกติแยกจากแถบ** — "ปกติ 11.3–14.3" อ่านได้ทันที ไม่ต้อง decode จากแถบสี
2. **สถานะสองชั้น** — จุดสี + ข้อความ ▼/▲/● ลดการพึ่งสีอย่างเดียว (บางส่วน)
3. **Off-scale handling** — ค่าหลุดสเกลแสดง ◀/▶ พร้อมตัวเลข แก้บั๊กจุดหายของรอบก่อน

---

## Priority Issues

### [P1] กราฟแคบเกินบน mobile (chart width ~260px ใน modal)
- **Why:** แพทย์/พยาบาลมักดูผลบนมือถือระหว่างคลินิก — แถบ 260px ทำให้จุด marker ทับกัน อ่านตำแหน่งยาก
- **Fix:** บน mobile ให้ Result Card 2 full-bleed ใน modal (ลด padding), หรือแสดงเป็น **ตาราง 3 คอลัมน์** (ตัวชี้วัด | ช่วงปกติ | ค่า+สถานะ) โดยซ่อนแถบ visual แล้วมี toggle "ดูแผนภาพ"
- **Command:** `/impeccable adapt Result Card 2 graph`

### [P1] Contrast ไม่ผ่าน WCAG บนข้อความสำคัญของกราฟ
- **Why:** `text-gray-400` (2.5:1), `text-amber-600` (3.2:1) — หน่วย, footnote, สถานะ "ต่ำกว่า" อ่านยากในห้องสว่าง
- **Fix:** ยก unit labels เป็น `text-gray-600`, status เป็น `text-amber-800`/`text-emerald-800`, footnote ≥12px + `text-gray-600`
- **Command:** `/impeccable audit refRangeChart contrast`

### [P1] กราฟไม่ accessible — ไม่มี aria, screen reader อ่านไม่ได้
- **Why:** HTML/CSS chart เป็น div ล้วน — Sam (screen reader) ได้แค่ "div div div"
- **Fix:** เพิ่ม `role="img"` + `aria-label` ต่อแถว หรือ `<table>` semantic พร้อม visually-hidden text สรุป "Hb 10.5 ต่ำกว่าช่วงปกติ 11.3–14.3"
- **Command:** `/impeccable harden refRangeChart a11y`

### [P2] สเกลแถวอิสระ — เปรียบเทียบข้ามพารามิเตอร์ไม่ได้
- **Why:** แต่ละแถว scale ต่างกัน (Hb band อยู่กลาง, RBC band อยู่ซ้าย) — สายตาเห็น "บันได" ไม่ใช่ alignment
- **Fix:** ยอมรับ per-row scale แต่เพิ่ม **min/max ของสเกล** ใต้แถบ หรือเปลี่ยนเป็น dot plot บนสเกลร่วมเฉพาะ % deviation from range
- **Command:** `/impeccable layout refRangeChart scale`

### [P2] Scatter MCV×RDW — axis/cutoff ไม่ объяс, ตัวอักษร 9px
- **Why:** พยาบาลไม่รู้ว่าเส้นประ MCV=80 / RDW=14.5 มาจากไหน; "IDA?" ไม่บอก confidence
- **Fix:** เพิ่ม legend ใต้ scatter: "เส้นประ: MCV&lt;80, RDW&gt;14.5" + แสดงค่า MCV/RDW ของคนไข้ + ข้อความ "สนับสนุน TT/IDA เท่านั้น"
- **Command:** `/impeccable clarify mcvRdwScatter`

---

## Persona Red Flags

**Jordan (พยาบาลใหม่):** เห็น "TT", "IDA", "IDA?" บน scatter โดยไม่มีคำแปลไทย — จะตีความผิดหรือข้ามกราฟไปเลย. Mentzer Index อยู่ใต้กราฟโดยไม่เชื่อม visual กับ scatter zone

**Sam (keyboard/screen reader):** กราฟทั้งสองเป็น div — ไม่ focusable, ไม่ announce สถานะ. สีส้ม=ต่ำ/แดง=สูง ยังพึ่งการมองเป็นหลักใน scatter badge

**Casey (มือถือ one-hand):** Modal ยาว ต้อง scroll ผ่าน Card 1 → 7 แถว → scatter → 3 indices → summary ก่อนถึงปุ่ม Agree/Disagree. Chart 260px บน iPhone width

---

## Minor Observations

- Header คอลัมน์ (`ตัวชี้วัด | ช่วงปกติ | ...`) ซ่อนบน mobile (`hidden sm:grid`) — ผู้ใช้มือถือไม่รู้ว่าคอลัมน์ขวาคืออะไร
- Purple theme Card 2 (`from-purple-50`, `border-purple-100`) ขัดกับ emerald clinical semantics ของแถบปกติ
- 7 แถว × card border = visual noise (nested-cards detector 18 hits)
- Scatter สูง 280px ใน modal ที่ scroll อยู่แล้ว — รู้สึกยาว

---

## Questions to Consider

- ถ้าแพทย์ต้องการแค่ "ค่าไหนผิดปกติ" — ตาราง 3 คอลัมน์พอไหม โดยไม่ต้องมีแถบ visual?
- Scatter TT/IDA ควรอยู่ใน Card 2 หรือแยกเป็น Card 3 ที่เปิดเมื่อ MCV/RDW ผิดปกติ?
- กลุ่มอายุ (Group 1/2) ควรแสดงช่วงปกติทั้ง 7 ค่าเป็น reference table ก่อนกราฟไหม?
