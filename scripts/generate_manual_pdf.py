from __future__ import annotations

import sys
from pathlib import Path

from fpdf import FPDF

MANUALS = {
    "usuario": (
        "MANUAL_USUARIO_MEDICLIPS_ADMIN.md",
        r"C:\Users\User\Desktop\MANUAL DE USUARIO MEDICLIPS (ADMIN).pdf",
    ),
    "tecnico": (
        "MANUAL_TECNICO_MEDICLIPS.md",
        r"C:\Users\User\Desktop\Manual Tecnico del Sistema MedicClips.pdf",
    ),
}


def read_manual_text(path: Path) -> str:
    text = path.read_text(encoding="utf-8")
    replacements = [
        ("**", ""),
        ("`", ""),
        ("---", "\n"),
        ("## ", "\n\n"),
        ("# ", "\n\n"),
        ("> ", ""),
    ]
    for a, b in replacements:
        text = text.replace(a, b)

    text = (
        text.replace("\u2014", "-")
        .replace("\u2013", "-")
        .replace("\u2019", "'")
        .replace("\u2018", "'")
        .replace("\u201c", '"')
        .replace("\u201d", '"')
        .replace("\u2026", "...")
        .replace("\u00a0", " ")
    )
    return text.strip() + "\n"


def build_pdf(text: str, out_path: Path) -> None:
    pdf = FPDF(format="A4")
    pdf.set_auto_page_break(auto=True, margin=15)
    pdf.add_page()
    epw = pdf.w - 2 * pdf.l_margin

    pdf.set_font("Helvetica", size=12)

    def wrap_long_tokens(s: str, limit: int = 80) -> str:
        parts: list[str] = []
        for token in s.split(" "):
            if len(token) <= limit:
                parts.append(token)
                continue
            chunks = [token[i : i + limit] for i in range(0, len(token), limit)]
            parts.append("\n".join(chunks))
        return " ".join(parts)

    for line in text.splitlines():
        line = line.replace("\t", "    ").rstrip()
        if not line:
            pdf.ln(4)
            continue

        if line.isupper() and len(line) <= 80:
            pdf.set_font("Helvetica", style="B", size=12)
            pdf.multi_cell(epw, 7, line)
            pdf.set_font("Helvetica", size=12)
            pdf.ln(1)
            continue

        if line[:2] in {"1.", "2.", "3.", "4."} and len(line) > 2 and line[2] in ". ":
            pdf.set_font("Helvetica", style="B", size=12)
            pdf.multi_cell(epw, 6, line)
            pdf.set_font("Helvetica", size=12)
            continue

        pdf.multi_cell(epw, 6, wrap_long_tokens(line))

    out_path.parent.mkdir(parents=True, exist_ok=True)
    pdf.output(str(out_path))


def main() -> None:
    kind = sys.argv[1] if len(sys.argv) > 1 else "tecnico"
    if kind not in MANUALS:
        print(f"Uso: python generate_manual_pdf.py [{'|'.join(MANUALS)}]")
        sys.exit(1)

    repo_root = Path(__file__).resolve().parents[1]
    md_name, out_pdf = MANUALS[kind]
    md_path = repo_root / "docs" / md_name
    out_path = Path(out_pdf)

    build_pdf(read_manual_text(md_path), out_path)
    print(f"OK: {out_path}")


if __name__ == "__main__":
    main()
