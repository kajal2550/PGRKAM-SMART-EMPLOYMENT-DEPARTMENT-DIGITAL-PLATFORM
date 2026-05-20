import { useState } from 'react'
import { useAuth } from '../context/AuthContext'
import { FiUser, FiPhone, FiMail, FiMapPin, FiBriefcase, FiSave, FiDownload } from 'react-icons/fi'
import toast from 'react-hot-toast'

const emptyResume = {
  personal: { name: '', email: '', phone: '', address: '', objective: '' },
  education: [{ degree: '', institution: '', year: '', grade: '' }],
  experience: [{ title: '', company: '', from: '', to: '', description: '' }],
  skills: '',
  languages: '',
}

export default function Resume() {
  const { user }    = useAuth()
  const [resume, setResume] = useState({
    ...emptyResume,
    personal: { name: user?.name || '', email: user?.email || '', phone: '', address: '', objective: '' },
  })
  const [tab, setTab] = useState('personal')
  const [saved, setSaved] = useState(false)

  const update = (section, value) =>
    setResume((prev) => ({ ...prev, [section]: value }))

  const updatePersonal = (field, val) =>
    update('personal', { ...resume.personal, [field]: val })

  const addItem = (section, template) =>
    update(section, [...resume[section], template])

  const updateItem = (section, idx, field, val) => {
    const arr = [...resume[section]]
    arr[idx] = { ...arr[idx], [field]: val }
    update(section, arr)
  }

  const handleSave = () => {
    setSaved(true)
    toast.success('Resume saved successfully!')
  }

  const tabs = ['personal', 'education', 'experience', 'skills']

  return (
    <div className="max-w-4xl mx-auto space-y-6 animate-fade-in">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-extrabold text-gray-900">Resume Builder</h1>
          <p className="text-gray-500 text-sm mt-1">Build and download your professional resume.</p>
        </div>
        <div className="flex gap-2">
          <button onClick={handleSave} className="btn-secondary text-sm flex items-center gap-2">
            <FiSave size={14} /> Save
          </button>
          <button className="btn-primary text-sm flex items-center gap-2" onClick={() => toast('Download feature coming soon!')}>
            <FiDownload size={14} /> Download PDF
          </button>
        </div>
      </div>

      {/* Tabs */}
      <div className="flex gap-2 border-b border-gray-200">
        {tabs.map((t) => (
          <button
            key={t}
            onClick={() => setTab(t)}
            className={`px-4 py-2 text-sm font-medium capitalize border-b-2 transition-colors ${
              tab === t
                ? 'border-primary-600 text-primary-700'
                : 'border-transparent text-gray-500 hover:text-gray-800'
            }`}
          >
            {t}
          </button>
        ))}
      </div>

      <div className="glass-card p-6">
        {/* Personal Information */}
        {tab === 'personal' && (
          <div className="space-y-4">
            <h2 className="font-bold text-gray-900">Personal Information</h2>
            <div className="grid sm:grid-cols-2 gap-4">
              {[
                { label: 'Full Name',    field: 'name',    icon: FiUser,      type: 'text'  },
                { label: 'Email',        field: 'email',   icon: FiMail,      type: 'email' },
                { label: 'Phone',        field: 'phone',   icon: FiPhone,     type: 'tel'   },
                { label: 'Address',      field: 'address', icon: FiMapPin,    type: 'text'  },
              ].map(({ label, field, icon: Icon, type }) => (
                <div key={field}>
                  <label className="text-sm font-medium text-gray-700 mb-1 block">{label}</label>
                  <div className="relative">
                    <Icon className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={15} />
                    <input type={type} value={resume.personal[field]}
                      onChange={(e) => updatePersonal(field, e.target.value)}
                      className="input-field pl-9 text-sm" />
                  </div>
                </div>
              ))}
            </div>
            <div>
              <label className="text-sm font-medium text-gray-700 mb-1 block">Career Objective</label>
              <textarea rows={4} value={resume.personal.objective}
                onChange={(e) => updatePersonal('objective', e.target.value)}
                placeholder="Brief career objective or summary…"
                className="input-field text-sm resize-none" />
            </div>
          </div>
        )}

        {/* Education */}
        {tab === 'education' && (
          <div className="space-y-4">
            <div className="flex items-center justify-between">
              <h2 className="font-bold text-gray-900">Education</h2>
              <button onClick={() => addItem('education', { degree: '', institution: '', year: '', grade: '' })}
                className="btn-secondary text-xs">+ Add</button>
            </div>
            {resume.education.map((edu, i) => (
              <div key={i} className="p-4 border border-gray-200 rounded-xl space-y-3">
                <p className="text-xs font-semibold text-gray-500 uppercase">Education #{i + 1}</p>
                <div className="grid sm:grid-cols-2 gap-3">
                  {[
                    { label: 'Degree / Course', field: 'degree' },
                    { label: 'Institution',      field: 'institution' },
                    { label: 'Year',             field: 'year' },
                    { label: 'Grade / CGPA',     field: 'grade' },
                  ].map(({ label, field }) => (
                    <div key={field}>
                      <label className="text-xs font-medium text-gray-600 mb-1 block">{label}</label>
                      <input type="text" value={edu[field]}
                        onChange={(e) => updateItem('education', i, field, e.target.value)}
                        className="input-field text-sm" />
                    </div>
                  ))}
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Experience */}
        {tab === 'experience' && (
          <div className="space-y-4">
            <div className="flex items-center justify-between">
              <h2 className="font-bold text-gray-900">Work Experience</h2>
              <button onClick={() => addItem('experience', { title: '', company: '', from: '', to: '', description: '' })}
                className="btn-secondary text-xs">+ Add</button>
            </div>
            {resume.experience.map((exp, i) => (
              <div key={i} className="p-4 border border-gray-200 rounded-xl space-y-3">
                <p className="text-xs font-semibold text-gray-500 uppercase">Experience #{i + 1}</p>
                <div className="grid sm:grid-cols-2 gap-3">
                  {[
                    { label: 'Job Title',  field: 'title'   },
                    { label: 'Company',    field: 'company' },
                    { label: 'From',       field: 'from'    },
                    { label: 'To',         field: 'to'      },
                  ].map(({ label, field }) => (
                    <div key={field}>
                      <label className="text-xs font-medium text-gray-600 mb-1 block">{label}</label>
                      <input type="text" value={exp[field]}
                        onChange={(e) => updateItem('experience', i, field, e.target.value)}
                        className="input-field text-sm" />
                    </div>
                  ))}
                </div>
                <div>
                  <label className="text-xs font-medium text-gray-600 mb-1 block">Description</label>
                  <textarea rows={3} value={exp.description}
                    onChange={(e) => updateItem('experience', i, 'description', e.target.value)}
                    className="input-field text-sm resize-none" />
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Skills */}
        {tab === 'skills' && (
          <div className="space-y-5">
            <h2 className="font-bold text-gray-900">Skills & Languages</h2>
            <div>
              <label className="text-sm font-medium text-gray-700 mb-1 block">
                Technical / Professional Skills
              </label>
              <textarea rows={4} value={resume.skills}
                onChange={(e) => update('skills', e.target.value)}
                placeholder="e.g., MS Office, Tally, Web Development, Electrician Work…"
                className="input-field text-sm resize-none" />
            </div>
            <div>
              <label className="text-sm font-medium text-gray-700 mb-1 block">Languages Known</label>
              <input type="text" value={resume.languages}
                onChange={(e) => update('languages', e.target.value)}
                placeholder="e.g., Punjabi, Hindi, English"
                className="input-field text-sm" />
            </div>
          </div>
        )}
      </div>

      {/* Resume Preview hint */}
      {saved && (
        <div className="glass-card p-4 border-l-4 border-green-500 animate-fade-in">
          <p className="text-green-700 text-sm font-medium">
            ✅ Resume saved! Use "Download PDF" to export your resume.
          </p>
        </div>
      )}
    </div>
  )
}
