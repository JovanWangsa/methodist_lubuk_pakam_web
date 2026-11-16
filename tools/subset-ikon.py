import sys
from fontTools.ttLib import TTFont
from fontTools import subset

src, ikon_file, out = sys.argv[1:4]
ikon = [l.strip() for l in open(ikon_file) if l.strip()]
font = TTFont(src)
cmap = font.getBestCmap()
rev = {g: chr(c) for c, g in cmap.items()}
peta = {}
for lookup in font["GSUB"].table.LookupList.Lookup:
    for st in lookup.SubTable:
        if st.LookupType == 7:
            st = st.ExtSubTable
        if getattr(st, "LookupType", None) != 4:
            continue
        for first, ligs in st.ligatures.items():
            for lig in ligs:
                try:
                    nama = rev[first] + "".join(rev[c] for c in lig.Component)
                except KeyError:
                    continue
                peta.setdefault(nama, lig.LigGlyph)
hilang = [i for i in ikon if i not in peta]
if hilang:
    sys.exit("Ikon tidak ditemukan: " + ", ".join(hilang))
opsi = subset.Options()
opsi.flavor = "woff2"
opsi.layout_features = ["liga", "rlig", "calt", "ccmp"]
opsi.layout_closure = False
opsi.notdef_outline = True
sub = subset.Subsetter(opsi)
huruf = "abcdefghijklmnopqrstuvwxyz0123456789_ "
sub.populate(text=huruf, glyphs=[peta[i] for i in ikon])
sub.subset(font)
font.flavor = "woff2"
font.save(out)
print("ikon:", len(ikon), "| sumbu variasi:", [a.axisTag for a in font["fvar"].axes])
