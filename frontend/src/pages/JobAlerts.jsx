import { useState, useEffect } from 'react'
import { FiBell, FiMapPin, FiBriefcase, FiBookOpen, FiPlus, FiTrash2, FiCheckCircle } from 'react-icons/fi'
import toast from 'react-hot-toast'

const DISTRICTS = [
  'Any District','Amritsar','Barnala','Bathinda','Faridkot','Fatehgarh Sahib','Fazilka','Ferozepur',
  'Gurdaspur','Hoshiarpur','Jalandhar','Kapurthala','Ludhiana','Mansa','Moga',
  'Mohali (SAS Nagar)','Muktsar','Nawanshahr','Pathankot','Patiala','Ropar',
  'Sangrur','Tarn Taran','Chandigarh',
]

const JOB_TYPES   = ['All Types', 'Government', 'Private']
const CATEGORIES  = ['All Categories','IT / Software','Health / Medical','Education / Teaching','Engineering / Technical','Finance / Banking','Police / Security','Agriculture','Electrician / Trade','Sales / Marketing','BPO / Customer Support','Other']

const STORAGE_KEY = 'pgrkam_job_alerts'

export default function JobAlerts() {
  const [alerts,  setAlerts]  = useState([])
  const [form,    setForm]    = useState({ district: 'Any District', type: 'All Types', category: 'All Categories', email: '' })
  const [saved,   setSaved]   = useState(false)

  // Load from localStorage
  useEffect(() => {
    try {
      const stored = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]')
      setAlerts(stored)
    } catch {/* ignore */}
  }, [])

  const persistAlerts = (newAlerts) => {
    setAlerts(newAlerts)
    localStorage.setItem(STORAGE_KEY, JSON.stringify(newAlerts))
  }

  const handleAdd = (e) => {
    e.preventDefault()
    if (!form.email.trim()) { toast.error('Please enter your email address'); return }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) { toast.error('Enter a valid email address'); return }
    if (alerts.length >= 5) { toast.error('Maximum 5 job alerts allowed'); return }

    const exists = alerts.some(a =>
      a.district === form.district && a.type === form.type && a.category === form.category
    )
    if (exists) { toast('Similar alert already exists!'); return }

    const newAlert = { ...form, id: Date.now(), createdAt: new Date().toLocaleDateString('en-IN') }
    persistAlerts([...alerts, newAlert])
    setSaved(true)
    toast.success('Job alert created! You will receive email notifications.')
    setTimeout(() => setSaved(false), 3000)
  }

  const handleRemove = (id) => {
    persistAlerts(alerts.filter(a => a.id !== id))
    toast.success('Alert removed')
  }

  return (
    <div className="max-w-3xl mx-auto space-y-6 animate-fade-in">
      {/* Header */}
      <div>
        <h1 className="text-2xl font-bold text-gray-900 flex items-center gap-2">
          <FiBell size={22} /> Job Alerts
        </h1>
        <p className="text-gray-500 mt-0.5 text-sm">
          Set up alerts — we'll notify you by email when new jobs match your preferences
        </p>
      </div>

      {/* Create alert form */}
      <div className="glass-card p-6">
        <h2 className="font-bold text-gray-800 mb-4 flex items-center gap-2">
          <FiPlus size={16} className="text-primary-600" /> Create New Alert
        </h2>
        <form onSubmit={handleAdd} className="space-y-4">
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label className="label-text flex items-center gap-1 mb-1"><FiMapPin size={12} /> District</label>
              <select value={form.district} onChange={e => setForm(p => ({ ...p, district: e.target.value }))} className="input-field">
                {DISTRICTS.map(d => <option key={d}>{d}</option>)}
              </select>
            </div>
            <div>
              <label className="label-text flex items-center gap-1 mb-1"><FiBriefcase size={12} /> Job Type</label>
              <select value={form.type} onChange={e => setForm(p => ({ ...p, type: e.target.value }))} className="input-field">
                {JOB_TYPES.map(t => <option key={t}>{t}</option>)}
              </select>
            </div>
          </div>
          <div>
            <label className="label-text flex items-center gap-1 mb-1"><FiBookOpen size={12} /> Job Category</label>
            <select value={form.category} onChange={e => setForm(p => ({ ...p, category: e.target.value }))} className="input-field">
              {CATEGORIES.map(c => <option key={c}>{c}</option>)}
            </select>
          </div>
          <div>
            <label className="label-text mb-1 block">Email for Notifications *</label>
            <input
              type="email"
              value={form.email}
              onChange={e => setForm(p => ({ ...p, email: e.target.value }))}
              className="input-field"
              placeholder="your@email.com"
              required
            />
          </div>
          <button type="submit" className={`w-full py-2.5 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 transition ${
            saved ? 'bg-green-500 text-white' : 'btn-primary'
          }`}>
            {saved ? <><FiCheckCircle size={15} /> Alert Saved!</> : <><FiPlus size={15} /> Create Alert</>}
          </button>
        </form>
      </div>

      {/* Active alerts */}
      {alerts.length > 0 && (
        <div className="space-y-3">
          <h2 className="font-bold text-gray-800">Active Alerts ({alerts.length}/5)</h2>
          {alerts.map(alert => (
            <div key={alert.id} className="glass-card p-4 flex items-center justify-between gap-4">
              <div className="flex-1">
                <div className="flex flex-wrap gap-2 mb-1">
                  <span className="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium">{alert.district}</span>
                  <span className="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-medium">{alert.type}</span>
                  <span className="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">{alert.category}</span>
                </div>
                <p className="text-xs text-gray-500">Notifications → <strong>{alert.email}</strong> · Created {alert.createdAt}</p>
              </div>
              <button
                onClick={() => handleRemove(alert.id)}
                className="p-2 rounded-lg text-red-400 hover:bg-red-50 hover:text-red-600 transition flex-shrink-0"
                title="Delete alert"
              >
                <FiTrash2 size={16} />
              </button>
            </div>
          ))}
        </div>
      )}

      {/* Info */}
      <div className="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600">
        <p className="font-semibold text-gray-700 mb-1">How Job Alerts Work</p>
        <ul className="space-y-1 text-xs">
          <li>✅ Set up to 5 alerts with different location, type &amp; category combinations</li>
          <li>✅ Get instant email when a matching job is posted on PGRKAM</li>
          <li>✅ Weekly digest of all new jobs matching your alert preferences</li>
          <li>✅ One-click unsubscribe from any alert email</li>
        </ul>
      </div>
    </div>
  )
}
