import { useState, useEffect } from 'react'
import { useAuth } from '../context/AuthContext'
import { userAPI } from '../api/axios'
import {
  FiUser, FiPhone, FiSave, FiDownload,
  FiPlus, FiTrash2, FiBook, FiBriefcase, FiAward,
  FiCheckCircle, FiStar, FiEdit3, FiFileText,
  FiUsers, FiPackage, FiHome, FiInfo
} from 'react-icons/fi'
import toast from 'react-hot-toast'

const TABS = [
  { key: 'personal',       label: 'Personal'       },
  { key: 'education',      label: 'Education'      },
  { key: 'experience',     label: 'Experience'     },
  { key: 'skills',         label: 'Skills'         },
  { key: 'certifications', label: 'Certifications' },
  { key: 'projects',       label: 'Projects'       },
  { key: 'references',     label: 'References'     },
  { key: 'extras',         label: 'Extras'         },
]

const emptyResume = {
  personal: {
    name: '', email: '', phone: '', altPhone: '', address: '', city: '',
    state: 'Punjab', pincode: '', dob: '', gender: '', maritalStatus: '',
    nationality: 'Indian', religion: '', category: '', fatherName: '',
    motherName: '', aadhaar: '', linkedin: '', portfolio: '', objective: ''
  },
  education: [
    { degree: '10th (Matriculation)', institution: '', board: '', year: '', percentage: '', subjects: '', location: '' },
    { degree: '12th (Intermediate)',  institution: '', board: '', year: '', percentage: '', subjects: '', location: '' },
  ],
  experience: [
    { title: '', company: '', type: 'Full-time', location: '', from: '', to: '', current: false, description: '', achievements: '' }
  ],
  skills: { technical: '', soft: '', computer: '', languages: 'Punjabi, Hindi, English' },
  certifications: [{ name: '', issuer: '', year: '', credentialId: '' }],
  projects:       [{ title: '', description: '', technologies: '', link: '', year: '' }],
  references:     [{ name: '', designation: '', organization: '', phone: '', email: '' }],
  extras: { hobbies: '', achievements: '', declaration: true }
}

export default function Resume() {
  const { user } = useAuth()
  const [resume, setResume] = useState({
    ...emptyResume,
    personal: { ...emptyResume.personal, name: user?.name || '', email: user?.email || '' },
  })
  const [tab,    setTab]    = useState('personal')
  const [saving, setSaving] = useState(false)
  const [loaded, setLoaded] = useState(false)

  useEffect(() => {
    if (!user) return
    userAPI.getResume().then(({ data }) => {
      if (data.resume) {
        setResume({
          personal:       { ...emptyResume.personal,       ...data.resume.personal       },
          education:      data.resume.education      || emptyResume.education,
          experience:     data.resume.experience     || emptyResume.experience,
          skills:         { ...emptyResume.skills,         ...data.resume.skills         },
          certifications: data.resume.certifications || emptyResume.certifications,
          projects:       data.resume.projects       || emptyResume.projects,
          references:     data.resume.references     || emptyResume.references,
          extras:         { ...emptyResume.extras,         ...data.resume.extras         },
        })
        setLoaded(true)
      }
    }).catch(() => {})
  }, [user])

  const update         = (section, value) => setResume(p => ({ ...p, [section]: value }))
  const updatePersonal = (field, val)     => update('personal', { ...resume.personal, [field]: val })
  const updateSkills   = (field, val)     => update('skills',   { ...resume.skills,   [field]: val })
  const updateExtras   = (field, val)     => update('extras',   { ...resume.extras,   [field]: val })

  const addItem = (section, template) => update(section, [...resume[section], { ...template }])
  const removeItem = (section, idx) => {
    const arr = resume[section].filter((_, i) => i !== idx)
    update(section, arr.length ? arr : [{ ...emptyResume[section][0] }])
  }
  const updateItem = (section, idx, field, val) => {
    const arr = [...resume[section]]
    arr[idx] = { ...arr[idx], [field]: val }
    update(section, arr)
  }

  const handleSave = async () => {
    setSaving(true)
    try {
      await userAPI.saveResume(resume)
      setLoaded(true)
      toast.success('Resume saved successfully!')
    } catch (err) {
      toast.error(err.response?.data?.message || 'Failed to save resume')
    } finally {
      setSaving(false)
    }
  }

  const handleDownload = () => {
    const p   = resume.personal
    const edu = resume.education
    const exp = resume.experience
    const sk  = resume.skills
    const cer = resume.certifications
    const prj = resume.projects
    const ref = resume.references
    const ext = resume.extras

    const html = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>${p.name} - Resume</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Segoe UI',Arial,sans-serif;font-size:13px;color:#1a1a1a;background:#fff;}
.page{max-width:820px;margin:0 auto;padding:36px 40px;}
.header{background:linear-gradient(135deg,#1e40af,#2563eb);color:#fff;border-radius:10px;padding:28px 32px;margin-bottom:24px;}
.header h1{font-size:26px;font-weight:700;}
.header .sub{font-size:13px;opacity:.85;margin-top:6px;}
.contact-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:12px;font-size:12px;opacity:.9;}
.section{margin-bottom:22px;}
.section-title{font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#1e40af;border-bottom:2px solid #bfdbfe;padding-bottom:5px;margin-bottom:12px;}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:8px 20px;margin-bottom:10px;}
.field label{font-size:10px;font-weight:600;color:#6b7280;text-transform:uppercase;}
.field p{font-size:13px;color:#111827;margin-top:1px;}
.card{border:1px solid #e5e7eb;border-radius:8px;padding:12px 16px;margin-bottom:10px;}
.card h3{font-size:14px;font-weight:600;color:#111827;}
.card .sub{font-size:12px;color:#6b7280;margin:2px 0 6px;}
.badge{display:inline-block;background:#dbeafe;color:#1d4ed8;font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;margin-right:5px;}
.desc{font-size:12px;color:#374151;line-height:1.6;margin-top:6px;white-space:pre-wrap;}
.tags{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px;}
.tag{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:6px;padding:3px 10px;font-size:12px;}
.decl{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:12px 16px;font-size:12px;color:#166534;}
@media print{body{-webkit-print-color-adjust:exact;}}
</style>
</head>
<body><div class="page">
<div class="header">
  <h1>${p.name || 'Your Name'}</h1>
  <div class="sub">${[p.city, p.state].filter(Boolean).join(', ')}${p.pincode ? ' – ' + p.pincode : ''}</div>
  <div class="contact-row">
    ${p.phone ? `<span>📞 ${p.phone}</span>` : ''}
    ${p.email ? `<span>✉ ${p.email}</span>` : ''}
    ${p.linkedin ? `<span>🔗 ${p.linkedin}</span>` : ''}
    ${p.portfolio ? `<span>🌐 ${p.portfolio}</span>` : ''}
  </div>
</div>
${p.dob || p.gender || p.fatherName || p.category ? `
<div class="section"><div class="section-title">Personal Information</div>
<div class="row2">
  ${p.dob ? `<div class="field"><label>Date of Birth</label><p>${p.dob}</p></div>` : ''}
  ${p.gender ? `<div class="field"><label>Gender</label><p>${p.gender}</p></div>` : ''}
  ${p.maritalStatus ? `<div class="field"><label>Marital Status</label><p>${p.maritalStatus}</p></div>` : ''}
  ${p.category ? `<div class="field"><label>Category</label><p>${p.category}</p></div>` : ''}
  ${p.fatherName ? `<div class="field"><label>Father's Name</label><p>${p.fatherName}</p></div>` : ''}
  ${p.motherName ? `<div class="field"><label>Mother's Name</label><p>${p.motherName}</p></div>` : ''}
  ${p.aadhaar ? `<div class="field"><label>Aadhaar</label><p>${p.aadhaar}</p></div>` : ''}
  ${p.nationality ? `<div class="field"><label>Nationality</label><p>${p.nationality}</p></div>` : ''}
  ${p.address ? `<div class="field" style="grid-column:1/-1"><label>Address</label><p>${p.address}, ${[p.city,p.state,p.pincode].filter(Boolean).join(', ')}</p></div>` : ''}
</div></div>` : ''}
${p.objective ? `<div class="section"><div class="section-title">Career Objective</div><p class="desc">${p.objective}</p></div>` : ''}
${edu.some(e => e.degree || e.institution) ? `
<div class="section"><div class="section-title">Education</div>
${edu.filter(e => e.institution || e.degree).map(e => `
<div class="card"><h3>${e.degree}</h3>
<div class="sub">${e.institution}${e.board ? ' · ' + e.board : ''}${e.location ? ' · ' + e.location : ''}</div>
${e.year ? `<span class="badge">Year: ${e.year}</span>` : ''}
${e.percentage ? `<span class="badge">${e.percentage}</span>` : ''}
${e.subjects ? `<span class="badge">${e.subjects}</span>` : ''}
</div>`).join('')}
</div>` : ''}
${exp.some(e => e.title || e.company) ? `
<div class="section"><div class="section-title">Work Experience</div>
${exp.filter(e => e.title || e.company).map(e => `
<div class="card"><h3>${e.title}</h3>
<div class="sub">${e.company}${e.location ? ' · ' + e.location : ''} · <strong>${e.from}${e.current ? ' – Present' : e.to ? ' – ' + e.to : ''}</strong></div>
${e.type ? `<span class="badge">${e.type}</span>` : ''}
${e.description ? `<p class="desc">${e.description}</p>` : ''}
${e.achievements ? `<p class="desc"><strong>Achievements:</strong> ${e.achievements}</p>` : ''}
</div>`).join('')}
</div>` : ''}
${sk.technical || sk.soft || sk.computer ? `
<div class="section"><div class="section-title">Skills</div>
${sk.technical ? `<p style="margin:6px 0 4px"><strong>Technical:</strong></p><div class="tags">${sk.technical.split(',').map(s=>s.trim()).filter(Boolean).map(s=>`<span class="tag">${s}</span>`).join('')}</div>` : ''}
${sk.soft ? `<p style="margin:10px 0 4px"><strong>Soft Skills:</strong></p><div class="tags">${sk.soft.split(',').map(s=>s.trim()).filter(Boolean).map(s=>`<span class="tag">${s}</span>`).join('')}</div>` : ''}
${sk.computer ? `<p style="margin:10px 0 4px"><strong>Computer Skills:</strong></p><div class="tags">${sk.computer.split(',').map(s=>s.trim()).filter(Boolean).map(s=>`<span class="tag">${s}</span>`).join('')}</div>` : ''}
${sk.languages ? `<p style="margin:10px 0 0"><strong>Languages Known:</strong> ${sk.languages}</p>` : ''}
</div>` : ''}
${cer.some(c => c.name) ? `
<div class="section"><div class="section-title">Certifications</div>
${cer.filter(c=>c.name).map(c=>`<div class="card"><h3>${c.name}</h3><div class="sub">${c.issuer}${c.year ? ' · ' + c.year : ''}${c.credentialId ? ' · ID: ' + c.credentialId : ''}</div></div>`).join('')}
</div>` : ''}
${prj.some(p => p.title) ? `
<div class="section"><div class="section-title">Projects</div>
${prj.filter(p=>p.title).map(p=>`<div class="card"><h3>${p.title}${p.year ? ' ('+p.year+')' : ''}</h3>
${p.technologies ? `<div class="tags" style="margin:4px 0">${p.technologies.split(',').map(t=>t.trim()).filter(Boolean).map(t=>`<span class="tag">${t}</span>`).join('')}</div>` : ''}
${p.description ? `<p class="desc">${p.description}</p>` : ''}
${p.link ? `<p style="font-size:12px;color:#2563eb;margin-top:4px">🔗 ${p.link}</p>` : ''}
</div>`).join('')}
</div>` : ''}
${ref.some(r => r.name) ? `
<div class="section"><div class="section-title">References</div>
<div class="row2">
${ref.filter(r=>r.name).map(r=>`<div class="card"><h3>${r.name}</h3><div class="sub">${r.designation}${r.organization ? ', '+r.organization : ''}</div>
${r.phone ? `<p style="font-size:12px">📞 ${r.phone}</p>` : ''}
${r.email ? `<p style="font-size:12px">✉ ${r.email}</p>` : ''}
</div>`).join('')}
</div></div>` : ''}
${ext.achievements ? `<div class="section"><div class="section-title">Achievements & Awards</div><p class="desc">${ext.achievements}</p></div>` : ''}
${ext.hobbies ? `<div class="section"><div class="section-title">Hobbies & Interests</div><p class="desc">${ext.hobbies}</p></div>` : ''}
${ext.declaration ? `<div class="decl"><strong>Declaration:</strong> I hereby declare that all the information furnished above is true, complete and correct to the best of my knowledge and belief.<br/><br/><strong>Date:</strong> ${new Date().toLocaleDateString('en-IN')} &nbsp;&nbsp; <strong>Place:</strong> ${p.city || '___________'} &nbsp;&nbsp; <strong>Signature:</strong> ___________</div>` : ''}
</div></body></html>`

    const blob = new Blob([html], { type: 'text/html' })
    const url  = URL.createObjectURL(blob)
    const a    = document.createElement('a')
    a.href     = url
    a.download = `${p.name || 'resume'}_PGRKAM.html`
    a.click()
    URL.revokeObjectURL(url)
    toast.success('Downloaded! Open in browser → Ctrl+P → Save as PDF')
  }

  // Helper components
  const Field = ({ label, children, className = '' }) => (
    <div className={className}>
      <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">{label}</label>
      {children}
    </div>
  )
  const Input = ({ value, onChange, type = 'text', placeholder = '' }) => (
    <input type={type} value={value} onChange={e => onChange(e.target.value)} placeholder={placeholder}
      className="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition" />
  )
  const Textarea = ({ value, onChange, placeholder = '', rows = 3 }) => (
    <textarea rows={rows} value={value} onChange={e => onChange(e.target.value)} placeholder={placeholder}
      className="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white resize-none transition" />
  )
  const Select = ({ value, onChange, options }) => (
    <select value={value} onChange={e => onChange(e.target.value)}
      className="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition">
      <option value="">— Select —</option>
      {options.map(o => <option key={o} value={o}>{o}</option>)}
    </select>
  )
  const CardHeader = ({ title, onRemove, canRemove }) => (
    <div className="flex items-center justify-between mb-4">
      <span className="text-xs font-bold text-blue-600 uppercase tracking-wider">{title}</span>
      {canRemove && (
        <button onClick={onRemove} className="text-red-400 hover:text-red-600 p-1 rounded hover:bg-red-50 transition">
          <FiTrash2 size={14} />
        </button>
      )}
    </div>
  )
  const AddBtn = ({ label, onClick }) => (
    <button onClick={onClick}
      className="flex items-center gap-1.5 text-sm font-medium text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
      <FiPlus size={14} /> {label}
    </button>
  )
  const SkillTags = ({ value }) => {
    const tags = (value || '').split(',').map(s => s.trim()).filter(Boolean)
    return tags.length > 0 ? (
      <div className="flex flex-wrap gap-1.5 mt-2">
        {tags.map((t, i) => (
          <span key={i} className="bg-blue-50 text-blue-700 border border-blue-200 text-xs px-2.5 py-1 rounded-full">{t}</span>
        ))}
      </div>
    ) : null
  }

  const tabIdx = TABS.findIndex(t => t.key === tab)

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Hero */}
      <div className="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700 text-white py-10 px-4">
        <div className="max-w-5xl mx-auto flex items-center justify-between gap-4 flex-wrap">
          <div>
            <div className="flex items-center gap-2 mb-1">
              <FiFileText size={18} className="text-blue-200" />
              <span className="text-blue-200 text-sm font-medium uppercase tracking-wider">PGRKAM Resume Builder</span>
            </div>
            <h1 className="text-3xl font-extrabold">Build Your Professional Resume</h1>
            <p className="text-blue-200 mt-1 text-sm">Fill all sections for a complete, govt-job-ready resume</p>
          </div>
          <div className="flex gap-3">
            <button onClick={handleSave} disabled={saving}
              className="flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
              {saving
                ? <><div className="w-3.5 h-3.5 border-2 border-white/40 border-t-white rounded-full animate-spin" /> Saving…</>
                : <><FiSave size={15} /> Save Resume</>}
            </button>
            <button onClick={handleDownload}
              className="flex items-center gap-2 bg-white text-blue-800 font-semibold px-5 py-2.5 rounded-xl hover:bg-blue-50 transition text-sm">
              <FiDownload size={15} /> Download
            </button>
          </div>
        </div>
      </div>

      <div className="max-w-5xl mx-auto px-4 py-6">
        {/* Progress */}
        <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 mb-5">
          <div className="flex items-center justify-between mb-2">
            <span className="text-xs font-semibold text-gray-600">Section {tabIdx + 1} of {TABS.length}: <span className="text-blue-600">{TABS[tabIdx].label}</span></span>
            {loaded && <span className="text-xs font-bold text-green-600 flex items-center gap-1"><FiCheckCircle size={12} /> Saved</span>}
          </div>
          <div className="flex gap-1">
            {TABS.map((t, i) => (
              <button key={t.key} onClick={() => setTab(t.key)}
                className={`h-1.5 flex-1 rounded-full transition-colors ${i <= tabIdx ? 'bg-blue-600' : 'bg-gray-200'}`} />
            ))}
          </div>
        </div>

        <div className="flex gap-5">
          {/* Sidebar */}
          <div className="w-44 shrink-0">
            <nav className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              {TABS.map((t, i) => (
                <button key={t.key} onClick={() => setTab(t.key)}
                  className={`w-full flex items-center gap-2 px-3 py-2.5 text-sm font-medium transition border-l-4 ${
                    tab === t.key
                      ? 'border-blue-600 bg-blue-50 text-blue-700'
                      : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-800'
                  }`}>
                  <span className={`w-5 h-5 flex items-center justify-center rounded-full text-xs font-bold ${
                    tab === t.key ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500'
                  }`}>{i + 1}</span>
                  {t.label}
                </button>
              ))}
            </nav>
            <div className="mt-3 bg-blue-50 border border-blue-200 rounded-xl p-3">
              <p className="text-xs text-blue-800 font-semibold">💡 Pro Tip</p>
              <p className="text-xs text-blue-700 mt-1 leading-relaxed">Fill all sections. Complete resumes get 3x more responses in govt jobs.</p>
            </div>
          </div>

          {/* Content */}
          <div className="flex-1 min-w-0">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

              {/* ── PERSONAL ─────────────────────────────── */}
              {tab === 'personal' && (
                <div className="space-y-7">
                  <SectionHeader icon={<FiUser size={15} className="text-blue-600" />} title="Personal Information" sub="Basic details as per official documents" />

                  <Group title="Contact Details">
                    <div className="grid sm:grid-cols-2 gap-4">
                      <Field label="Full Name *"><Input value={resume.personal.name} onChange={v => updatePersonal('name', v)} placeholder="As per Aadhaar card" /></Field>
                      <Field label="Email Address *"><Input type="email" value={resume.personal.email} onChange={v => updatePersonal('email', v)} /></Field>
                      <Field label="Mobile Number *"><Input type="tel" value={resume.personal.phone} onChange={v => updatePersonal('phone', v)} placeholder="+91 XXXXX XXXXX" /></Field>
                      <Field label="Alternate Phone"><Input type="tel" value={resume.personal.altPhone} onChange={v => updatePersonal('altPhone', v)} placeholder="Optional" /></Field>
                      <Field label="LinkedIn Profile"><Input value={resume.personal.linkedin} onChange={v => updatePersonal('linkedin', v)} placeholder="linkedin.com/in/yourname" /></Field>
                      <Field label="Portfolio / Website"><Input value={resume.personal.portfolio} onChange={v => updatePersonal('portfolio', v)} placeholder="github.com/yourname" /></Field>
                    </div>
                  </Group>

                  <Group title="Address">
                    <div className="grid sm:grid-cols-2 gap-4">
                      <Field label="Full Address" className="sm:col-span-2"><Input value={resume.personal.address} onChange={v => updatePersonal('address', v)} placeholder="House No., Street, Village / Mohalla" /></Field>
                      <Field label="City / Town"><Input value={resume.personal.city} onChange={v => updatePersonal('city', v)} placeholder="e.g., Ludhiana" /></Field>
                      <Field label="State"><Input value={resume.personal.state} onChange={v => updatePersonal('state', v)} /></Field>
                      <Field label="PIN Code"><Input value={resume.personal.pincode} onChange={v => updatePersonal('pincode', v)} placeholder="6-digit PIN" /></Field>
                    </div>
                  </Group>

                  <Group title="Personal Details (Required for Govt Applications)">
                    <div className="grid sm:grid-cols-2 gap-4">
                      <Field label="Date of Birth"><Input type="date" value={resume.personal.dob} onChange={v => updatePersonal('dob', v)} /></Field>
                      <Field label="Gender"><Select value={resume.personal.gender} onChange={v => updatePersonal('gender', v)} options={['Male', 'Female', 'Transgender', 'Prefer not to say']} /></Field>
                      <Field label="Marital Status"><Select value={resume.personal.maritalStatus} onChange={v => updatePersonal('maritalStatus', v)} options={['Single', 'Married', 'Divorced', 'Widowed']} /></Field>
                      <Field label="Nationality"><Input value={resume.personal.nationality} onChange={v => updatePersonal('nationality', v)} /></Field>
                      <Field label="Category (Reservation)"><Select value={resume.personal.category} onChange={v => updatePersonal('category', v)} options={['General', 'OBC', 'SC', 'ST', 'EWS', 'PWD', 'Ex-Serviceman']} /></Field>
                      <Field label="Religion"><Input value={resume.personal.religion} onChange={v => updatePersonal('religion', v)} placeholder="Optional" /></Field>
                      <Field label="Father's Name"><Input value={resume.personal.fatherName} onChange={v => updatePersonal('fatherName', v)} /></Field>
                      <Field label="Mother's Name"><Input value={resume.personal.motherName} onChange={v => updatePersonal('motherName', v)} /></Field>
                      <Field label="Aadhaar Number" className="sm:col-span-2"><Input value={resume.personal.aadhaar} onChange={v => updatePersonal('aadhaar', v)} placeholder="12-digit Aadhaar number" /></Field>
                    </div>
                  </Group>

                  <Group title="Career Objective / Summary">
                    <Textarea value={resume.personal.objective} rows={5} onChange={v => updatePersonal('objective', v)}
                      placeholder="Write 3–4 sentences: your qualification, key skill, experience, and career goal. E.g., 'Motivated B.Com graduate with 2 years of accounting experience and Tally ERP expertise, seeking a challenging finance role in a growth-oriented organization…'" />
                    <p className="text-xs text-gray-400 mt-1">Tip: Tailor this to each job you apply for.</p>
                  </Group>
                </div>
              )}

              {/* ── EDUCATION ────────────────────────────── */}
              {tab === 'education' && (
                <div className="space-y-5">
                  <div className="flex items-center justify-between">
                    <SectionHeader icon={<FiBook size={15} className="text-blue-600" />} title="Education Details" sub="Add from 10th onwards — latest first" />
                    <AddBtn label="Add Qualification" onClick={() => addItem('education', { degree: '', institution: '', board: '', year: '', percentage: '', subjects: '', location: '' })} />
                  </div>
                  {resume.education.map((edu, i) => (
                    <div key={i} className="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white">
                      <CardHeader title={`Qualification ${i + 1}`} canRemove={resume.education.length > 1} onRemove={() => removeItem('education', i)} />
                      <div className="grid sm:grid-cols-2 gap-4">
                        <Field label="Degree / Qualification *"><Input value={edu.degree} onChange={v => updateItem('education', i, 'degree', v)} placeholder="e.g., 10th, 12th, B.A., B.Tech, ITI, Diploma…" /></Field>
                        <Field label="Specialization / Stream"><Input value={edu.subjects} onChange={v => updateItem('education', i, 'subjects', v)} placeholder="e.g., Science (PCM), Commerce, ECE, Civil…" /></Field>
                        <Field label="School / College / Institution *"><Input value={edu.institution} onChange={v => updateItem('education', i, 'institution', v)} placeholder="Full name of institution" /></Field>
                        <Field label="Board / University"><Input value={edu.board} onChange={v => updateItem('education', i, 'board', v)} placeholder="e.g., PSEB, CBSE, Punjab University, PTU, NCVT…" /></Field>
                        <Field label="Year of Passing"><Input value={edu.year} onChange={v => updateItem('education', i, 'year', v)} placeholder="e.g., 2022" /></Field>
                        <Field label="Marks / Percentage / CGPA"><Input value={edu.percentage} onChange={v => updateItem('education', i, 'percentage', v)} placeholder="e.g., 75.4% or 8.2 CGPA" /></Field>
                        <Field label="Location (City, State)"><Input value={edu.location} onChange={v => updateItem('education', i, 'location', v)} placeholder="e.g., Ludhiana, Punjab" /></Field>
                      </div>
                    </div>
                  ))}
                </div>
              )}

              {/* ── EXPERIENCE ───────────────────────────── */}
              {tab === 'experience' && (
                <div className="space-y-5">
                  <div className="flex items-center justify-between">
                    <SectionHeader icon={<FiBriefcase size={15} className="text-blue-600" />} title="Work Experience" sub="Include internships, part-time, apprenticeships, volunteer work" />
                    <AddBtn label="Add Experience" onClick={() => addItem('experience', { title: '', company: '', type: 'Full-time', location: '', from: '', to: '', current: false, description: '', achievements: '' })} />
                  </div>
                  {resume.experience.map((exp, i) => (
                    <div key={i} className="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white">
                      <CardHeader title={`Experience ${i + 1}`} canRemove={resume.experience.length > 1} onRemove={() => removeItem('experience', i)} />
                      <div className="grid sm:grid-cols-2 gap-4">
                        <Field label="Job Title / Designation *"><Input value={exp.title} onChange={v => updateItem('experience', i, 'title', v)} placeholder="e.g., Data Entry Operator, Electrician, Teacher…" /></Field>
                        <Field label="Company / Organization *"><Input value={exp.company} onChange={v => updateItem('experience', i, 'company', v)} placeholder="Full company name" /></Field>
                        <Field label="Employment Type"><Select value={exp.type} onChange={v => updateItem('experience', i, 'type', v)} options={['Full-time', 'Part-time', 'Contract', 'Internship', 'Apprenticeship', 'Freelance', 'Volunteer']} /></Field>
                        <Field label="Work Location"><Input value={exp.location} onChange={v => updateItem('experience', i, 'location', v)} placeholder="City, State" /></Field>
                        <Field label="Start Date"><Input type="month" value={exp.from} onChange={v => updateItem('experience', i, 'from', v)} /></Field>
                        <Field label="End Date">
                          {!exp.current && <Input type="month" value={exp.to} onChange={v => updateItem('experience', i, 'to', v)} />}
                          <label className="flex items-center gap-2 cursor-pointer mt-2">
                            <input type="checkbox" checked={exp.current} onChange={e => updateItem('experience', i, 'current', e.target.checked)} className="w-3.5 h-3.5 accent-blue-600" />
                            <span className="text-xs text-gray-600 font-medium">Currently working here</span>
                          </label>
                        </Field>
                        <Field label="Job Description & Responsibilities" className="sm:col-span-2">
                          <Textarea value={exp.description} rows={4} onChange={v => updateItem('experience', i, 'description', v)}
                            placeholder="• Managed day-to-day accounts and financial records&#10;• Prepared monthly reports and balance sheets&#10;• Handled client communication and documentation" />
                        </Field>
                        <Field label="Key Achievements" className="sm:col-span-2">
                          <Textarea value={exp.achievements} rows={2} onChange={v => updateItem('experience', i, 'achievements', v)}
                            placeholder="e.g., Reduced billing errors by 30%, Completed project 2 weeks ahead of schedule, Received Employee of the Month award…" />
                        </Field>
                      </div>
                    </div>
                  ))}
                  <div className="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-700">
                    💡 <strong>No experience?</strong> Add college projects, NSS/NCC activities, part-time work, or community service — it all counts!
                  </div>
                </div>
              )}

              {/* ── SKILLS ───────────────────────────────── */}
              {tab === 'skills' && (
                <div className="space-y-6">
                  <SectionHeader icon={<FiStar size={15} className="text-blue-600" />} title="Skills & Languages" sub="Separate each skill with a comma — they appear as tags in your resume" />
                  <Field label="Technical / Professional Skills">
                    <Textarea value={resume.skills.technical} rows={3} onChange={v => updateSkills('technical', v)}
                      placeholder="e.g., Tally ERP, AutoCAD, MS Office, Python, HTML/CSS, Electrical Wiring, Adobe Photoshop, Data Entry (50 WPM)…" />
                    <SkillTags value={resume.skills.technical} />
                    <p className="text-xs text-gray-400 mt-1">Add skills directly relevant to your target job</p>
                  </Field>
                  <Field label="Soft Skills">
                    <Textarea value={resume.skills.soft} rows={2} onChange={v => updateSkills('soft', v)}
                      placeholder="e.g., Communication, Leadership, Teamwork, Problem Solving, Time Management, Multitasking, Customer Service…" />
                    <SkillTags value={resume.skills.soft} />
                  </Field>
                  <Field label="Computer & IT Skills">
                    <Textarea value={resume.skills.computer} rows={2} onChange={v => updateSkills('computer', v)}
                      placeholder="e.g., MS Word, Excel, PowerPoint, Internet, Email, Typing Speed: 40 WPM, Tally, ERP Software…" />
                    <SkillTags value={resume.skills.computer} />
                  </Field>
                  <Field label="Languages Known (Read / Write / Speak)">
                    <Input value={resume.skills.languages} onChange={v => updateSkills('languages', v)}
                      placeholder="e.g., Punjabi (Fluent), Hindi (Fluent), English (Working Proficiency)" />
                    <SkillTags value={resume.skills.languages} />
                  </Field>
                </div>
              )}

              {/* ── CERTIFICATIONS ───────────────────────── */}
              {tab === 'certifications' && (
                <div className="space-y-5">
                  <div className="flex items-center justify-between">
                    <SectionHeader icon={<FiAward size={15} className="text-blue-600" />} title="Certifications & Courses" sub="Govt certificates, ITI, online courses, diplomas" />
                    <AddBtn label="Add Certificate" onClick={() => addItem('certifications', { name: '', issuer: '', year: '', credentialId: '' })} />
                  </div>
                  {resume.certifications.map((cert, i) => (
                    <div key={i} className="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white">
                      <CardHeader title={`Certificate ${i + 1}`} canRemove={resume.certifications.length > 1} onRemove={() => removeItem('certifications', i)} />
                      <div className="grid sm:grid-cols-2 gap-4">
                        <Field label="Certificate / Course Name *"><Input value={cert.name} onChange={v => updateItem('certifications', i, 'name', v)} placeholder="e.g., ITI Electrician, Google Digital Marketing, Tally ERP 9…" /></Field>
                        <Field label="Issuing Organization / Institute"><Input value={cert.issuer} onChange={v => updateItem('certifications', i, 'issuer', v)} placeholder="e.g., NCVT, PSSDM, Google, Coursera, NIELIT…" /></Field>
                        <Field label="Year of Completion"><Input value={cert.year} onChange={v => updateItem('certifications', i, 'year', v)} placeholder="e.g., 2023" /></Field>
                        <Field label="Certificate / Credential ID (Optional)"><Input value={cert.credentialId} onChange={v => updateItem('certifications', i, 'credentialId', v)} placeholder="Registration or credential number" /></Field>
                      </div>
                    </div>
                  ))}
                </div>
              )}

              {/* ── PROJECTS ─────────────────────────────── */}
              {tab === 'projects' && (
                <div className="space-y-5">
                  <div className="flex items-center justify-between">
                    <SectionHeader icon={<FiPackage size={15} className="text-blue-600" />} title="Projects" sub="College projects, personal work, freelance assignments" />
                    <AddBtn label="Add Project" onClick={() => addItem('projects', { title: '', description: '', technologies: '', link: '', year: '' })} />
                  </div>
                  {resume.projects.map((proj, i) => (
                    <div key={i} className="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white">
                      <CardHeader title={`Project ${i + 1}`} canRemove={resume.projects.length > 1} onRemove={() => removeItem('projects', i)} />
                      <div className="grid sm:grid-cols-2 gap-4">
                        <Field label="Project Title *"><Input value={proj.title} onChange={v => updateItem('projects', i, 'title', v)} placeholder="e.g., Smart Irrigation System, NGO Website, Inventory App…" /></Field>
                        <Field label="Year"><Input value={proj.year} onChange={v => updateItem('projects', i, 'year', v)} placeholder="e.g., 2023" /></Field>
                        <Field label="Technologies / Tools Used" className="sm:col-span-2">
                          <Input value={proj.technologies} onChange={v => updateItem('projects', i, 'technologies', v)} placeholder="e.g., PHP, MySQL, Bootstrap, Arduino, React, Python…" />
                          <SkillTags value={proj.technologies} />
                        </Field>
                        <Field label="Project Description" className="sm:col-span-2">
                          <Textarea value={proj.description} rows={3} onChange={v => updateItem('projects', i, 'description', v)}
                            placeholder="Explain what the project does, your role in it, challenges solved, and the outcome or impact…" />
                        </Field>
                        <Field label="Project Link / GitHub URL" className="sm:col-span-2">
                          <Input value={proj.link} onChange={v => updateItem('projects', i, 'link', v)} placeholder="https://github.com/username/project (optional)" />
                        </Field>
                      </div>
                    </div>
                  ))}
                </div>
              )}

              {/* ── REFERENCES ───────────────────────────── */}
              {tab === 'references' && (
                <div className="space-y-5">
                  <div className="flex items-center justify-between">
                    <SectionHeader icon={<FiUsers size={15} className="text-blue-600" />} title="References" sub="2–3 people who can vouch for your character or work" />
                    <AddBtn label="Add Reference" onClick={() => addItem('references', { name: '', designation: '', organization: '', phone: '', email: '' })} />
                  </div>
                  {resume.references.map((ref, i) => (
                    <div key={i} className="border border-gray-200 rounded-xl p-5 bg-gradient-to-br from-gray-50 to-white">
                      <CardHeader title={`Reference ${i + 1}`} canRemove={resume.references.length > 1} onRemove={() => removeItem('references', i)} />
                      <div className="grid sm:grid-cols-2 gap-4">
                        <Field label="Full Name *"><Input value={ref.name} onChange={v => updateItem('references', i, 'name', v)} placeholder="Referee's full name" /></Field>
                        <Field label="Designation / Position"><Input value={ref.designation} onChange={v => updateItem('references', i, 'designation', v)} placeholder="e.g., Principal, Manager, Sarpanch, HOD…" /></Field>
                        <Field label="Organization / Institution" className="sm:col-span-2"><Input value={ref.organization} onChange={v => updateItem('references', i, 'organization', v)} placeholder="Company or institution name and location" /></Field>
                        <Field label="Phone Number"><Input type="tel" value={ref.phone} onChange={v => updateItem('references', i, 'phone', v)} /></Field>
                        <Field label="Email Address"><Input type="email" value={ref.email} onChange={v => updateItem('references', i, 'email', v)} /></Field>
                      </div>
                    </div>
                  ))}
                  <div className="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800">
                    ⚠️ Always take permission before listing someone as a reference. Choose people who know your work well — teachers, employers, or community leaders.
                  </div>
                </div>
              )}

              {/* ── EXTRAS ───────────────────────────────── */}
              {tab === 'extras' && (
                <div className="space-y-6">
                  <SectionHeader icon={<FiFileText size={15} className="text-blue-600" />} title="Extras" sub="Achievements, hobbies, and declaration" />
                  <Field label="Achievements & Awards">
                    <Textarea value={resume.extras.achievements} rows={4} onChange={v => updateExtras('achievements', v)}
                      placeholder="e.g., State-level sports participant, Best Student Award 2022, NSS Certificate, NCC B Certificate, Merit Scholarship, District Topper in 12th…" />
                    <p className="text-xs text-gray-400 mt-1">List any academic, sports, cultural, or civic achievements</p>
                  </Field>
                  <Field label="Hobbies & Interests">
                    <Textarea value={resume.extras.hobbies} rows={3} onChange={v => updateExtras('hobbies', v)}
                      placeholder="e.g., Cricket, Reading, Photography, Painting, Social Work, Yoga, Cooking, Music, Gardening, Travelling…" />
                  </Field>
                  <div className="bg-gray-50 border border-gray-200 rounded-xl p-4">
                    <label className="flex items-start gap-3 cursor-pointer">
                      <input type="checkbox" checked={resume.extras.declaration} onChange={e => updateExtras('declaration', e.target.checked)} className="mt-0.5 w-4 h-4 accent-blue-600" />
                      <div>
                        <p className="text-sm font-semibold text-gray-800">Include Declaration</p>
                        <p className="text-xs text-gray-500 mt-1 italic leading-relaxed">
                          "I hereby declare that all the information furnished above is true, complete and correct to the best of my knowledge and belief."
                        </p>
                      </div>
                    </label>
                  </div>
                  <div className="bg-green-50 border border-green-200 rounded-xl p-4">
                    <p className="text-sm font-semibold text-green-800 flex items-center gap-1.5">
                      <FiCheckCircle size={14} /> Ready to export your resume?
                    </p>
                    <p className="text-xs text-green-700 mt-1 leading-relaxed">
                      Click <strong>Save Resume</strong> first, then <strong>Download</strong> to get an HTML file.
                      Open it in Chrome / Edge → press <strong>Ctrl+P</strong> → choose <strong>Save as PDF</strong>.
                    </p>
                  </div>
                </div>
              )}

            </div>

            {/* Navigation bar */}
            <div className="flex items-center justify-between mt-4 bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3">
              <div>
                {tabIdx > 0 && (
                  <button onClick={() => setTab(TABS[tabIdx - 1].key)}
                    className="text-sm font-medium text-gray-600 hover:text-blue-600 border border-gray-200 hover:border-blue-300 px-4 py-2 rounded-lg transition">
                    ← {TABS[tabIdx - 1].label}
                  </button>
                )}
              </div>
              <div className="flex gap-2">
                <button onClick={handleSave} disabled={saving}
                  className="flex items-center gap-1.5 text-sm font-semibold text-blue-700 border border-blue-300 hover:bg-blue-50 px-4 py-2 rounded-lg transition">
                  {saving ? 'Saving…' : <><FiSave size={13} /> Save</>}
                </button>
                {tabIdx < TABS.length - 1 ? (
                  <button onClick={() => setTab(TABS[tabIdx + 1].key)}
                    className="text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                    {TABS[tabIdx + 1].label} →
                  </button>
                ) : (
                  <button onClick={handleDownload}
                    className="flex items-center gap-1.5 text-sm font-semibold bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg transition">
                    <FiDownload size={13} /> Download Resume
                  </button>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

// Small helper components defined outside to avoid re-creation on render
function SectionHeader({ icon, title, sub }) {
  return (
    <div className="flex items-center gap-2.5 mb-1">
      <div className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">{icon}</div>
      <div>
        <h2 className="font-bold text-gray-900 text-base">{title}</h2>
        {sub && <p className="text-xs text-gray-500">{sub}</p>}
      </div>
    </div>
  )
}
function Group({ title, children }) {
  return (
    <div>
      <p className="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3 pb-1 border-b border-blue-100">{title}</p>
      {children}
    </div>
  )
}
