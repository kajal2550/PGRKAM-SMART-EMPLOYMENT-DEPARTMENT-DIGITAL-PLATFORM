import { useState, useEffect } from 'react'
import {
  FiUser, FiPhone, FiMapPin, FiBook, FiStar, FiLock,
  FiSave, FiCalendar, FiMail, FiShield, FiCheckCircle,
  FiEdit3, FiKey, FiEye, FiEyeOff, FiInfo, FiHome
} from 'react-icons/fi'
import { userAPI } from '../api/axios'
import { useAuth } from '../context/AuthContext'
import toast from 'react-hot-toast'

const DISTRICTS = [
  'Amritsar','Barnala','Bathinda','Faridkot','Fatehgarh Sahib','Fazilka','Ferozepur',
  'Gurdaspur','Hoshiarpur','Jalandhar','Kapurthala','Ludhiana','Mansa','Moga',
  'Mohali (SAS Nagar)','Muktsar','Nawanshahr','Pathankot','Patiala','Ropar',
  'Sangrur','Shahid Bhagat Singh Nagar','Tarn Taran','Chandigarh',
]
const QUALIFICATIONS = [
  'Below 8th','8th Pass','10th Pass','10+2 / Intermediate','ITI / Diploma',
  'Graduate (B.A/B.Sc/B.Com)','Graduate (B.Tech/BE)','Post Graduate','PhD',
]

const TABS = [
  { key: 'profile',  label: 'Personal Info',     icon: FiEdit3  },
  { key: 'password', label: 'Change Password',    icon: FiKey    },
  { key: 'account',  label: 'Account Info',       icon: FiInfo   },
]

export default function ProfileSettings() {
  const { user, setUser } = useAuth()
  const [tab,      setTab]      = useState('profile')
  const [saving,   setSaving]   = useState(false)
  const [pwSaving, setPwSaving] = useState(false)
  const [showPw,   setShowPw]   = useState({ current: false, new: false, confirm: false })

  const [form, setForm] = useState({
    name: '', phone: '', district: '', qualification: '', skills: '', dob: '', gender: '', address: '',
  })
  const [pwForm, setPwForm] = useState({
    current_password: '', new_password: '', new_password_confirmation: ''
  })

  useEffect(() => {
    userAPI.getProfile().then(({ data }) => {
      const u = data.user || data
      setForm({
        name:          u.name          || '',
        phone:         u.phone         || '',
        district:      u.district      || '',
        qualification: u.qualification || '',
        skills:        u.skills        || '',
        dob:           u.dob           || '',
        gender:        u.gender        || '',
        address:       u.address       || '',
      })
    }).catch(() => {})
  }, [])

  const set = (field, val) => setForm(p => ({ ...p, [field]: val }))

  // Profile completion %
  const fields = ['name', 'phone', 'dob', 'gender', 'district', 'qualification', 'skills', 'address']
  const filled  = fields.filter(f => form[f]?.trim()).length
  const pct     = Math.round((filled / fields.length) * 100)

  const skillTags = (form.skills || '').split(',').map(s => s.trim()).filter(Boolean)

  const handleSaveProfile = async (e) => {
    e.preventDefault()
    if (!form.name.trim()) { toast.error('Name is required'); return }
    setSaving(true)
    try {
      const { data } = await userAPI.updateProfile(form)
      if (setUser) setUser(data.user || data)
      toast.success('Profile updated successfully!')
    } catch (err) {
      const errs = err.response?.data?.errors
      if (errs) toast.error(Object.values(errs)[0]?.[0])
      else toast.error('Failed to update profile')
    } finally {
      setSaving(false)
    }
  }

  const handleChangePassword = async (e) => {
    e.preventDefault()
    if (!pwForm.current_password)             { toast.error('Enter current password'); return }
    if (pwForm.new_password.length < 8)        { toast.error('New password must be at least 8 characters'); return }
    if (pwForm.new_password !== pwForm.new_password_confirmation) { toast.error('Passwords do not match'); return }
    setPwSaving(true)
    try {
      await userAPI.changePassword(pwForm)
      toast.success('Password changed successfully!')
      setPwForm({ current_password: '', new_password: '', new_password_confirmation: '' })
    } catch (err) {
      const errs = err.response?.data?.errors
      if (errs) toast.error(Object.values(errs)[0]?.[0])
      else toast.error('Failed to change password')
    } finally {
      setPwSaving(false)
    }
  }

  // Password strength
  const pwStrength = (() => {
    const p = pwForm.new_password
    if (!p) return null
    let score = 0
    if (p.length >= 8)  score++
    if (/[A-Z]/.test(p)) score++
    if (/[0-9]/.test(p)) score++
    if (/[^A-Za-z0-9]/.test(p)) score++
    if (score <= 1) return { label: 'Weak',   color: 'bg-red-500',    w: 'w-1/4' }
    if (score === 2) return { label: 'Fair',   color: 'bg-orange-400', w: 'w-2/4' }
    if (score === 3) return { label: 'Good',   color: 'bg-yellow-400', w: 'w-3/4' }
    return               { label: 'Strong', color: 'bg-green-500',  w: 'w-full' }
  })()

  const avatar = (form.name || user?.name || 'U').charAt(0).toUpperCase()

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Hero */}
      <div className="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700 text-white">
        <div className="max-w-5xl mx-auto px-4 py-10">
          <div className="flex items-center gap-6 flex-wrap">
            {/* Avatar */}
            <div className="relative">
              <div className="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur border-2 border-white/40 flex items-center justify-center text-white font-bold text-3xl shadow-xl">
                {avatar}
              </div>
              <div className="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-blue-800" />
            </div>

            {/* Name & info */}
            <div className="flex-1 min-w-0">
              <h1 className="text-2xl font-extrabold truncate">{form.name || user?.name || 'Your Name'}</h1>
              <p className="text-blue-200 text-sm flex items-center gap-1.5 mt-0.5">
                <FiMail size={13} /> {user?.email}
              </p>
              {form.district && (
                <p className="text-blue-200 text-sm flex items-center gap-1.5 mt-0.5">
                  <FiMapPin size={13} /> {form.district}, Punjab
                </p>
              )}
              <div className="flex gap-2 mt-2 flex-wrap">
                <span className="bg-green-500/20 border border-green-400/40 text-green-300 text-xs font-semibold px-2.5 py-1 rounded-full">
                  ✓ Active Account
                </span>
                {form.qualification && (
                  <span className="bg-white/10 border border-white/20 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                    {form.qualification}
                  </span>
                )}
              </div>
            </div>

            {/* Completion ring */}
            <div className="bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-center min-w-[120px]">
              <div className="text-3xl font-extrabold text-white">{pct}%</div>
              <div className="text-xs text-blue-200 mt-0.5">Profile Complete</div>
              <div className="mt-2 h-1.5 bg-white/20 rounded-full overflow-hidden w-24">
                <div className="h-full bg-green-400 rounded-full transition-all" style={{ width: `${pct}%` }} />
              </div>
              <p className="text-xs text-blue-300 mt-1">{filled}/{fields.length} fields</p>
            </div>
          </div>
        </div>
      </div>

      <div className="max-w-5xl mx-auto px-4 py-6">
        <div className="flex gap-5">
          {/* Sidebar */}
          <div className="w-48 shrink-0">
            <nav className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              {TABS.map(t => (
                <button key={t.key} onClick={() => setTab(t.key)}
                  className={`w-full flex items-center gap-2.5 px-4 py-3 text-sm font-medium transition border-l-4 ${
                    tab === t.key
                      ? 'border-blue-600 bg-blue-50 text-blue-700'
                      : 'border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-800'
                  }`}>
                  <t.icon size={15} className={tab === t.key ? 'text-blue-600' : 'text-gray-400'} />
                  {t.label}
                </button>
              ))}
            </nav>

            {/* Completion checklist */}
            <div className="mt-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
              <p className="text-xs font-bold text-gray-700 mb-3">Complete your profile</p>
              <div className="space-y-2">
                {[
                  { label: 'Name',          done: !!form.name },
                  { label: 'Phone',         done: !!form.phone },
                  { label: 'Date of Birth', done: !!form.dob },
                  { label: 'Gender',        done: !!form.gender },
                  { label: 'District',      done: !!form.district },
                  { label: 'Qualification', done: !!form.qualification },
                  { label: 'Skills',        done: !!form.skills },
                  { label: 'Address',       done: !!form.address },
                ].map(item => (
                  <div key={item.label} className="flex items-center gap-2">
                    <FiCheckCircle size={13} className={item.done ? 'text-green-500' : 'text-gray-300'} />
                    <span className={`text-xs ${item.done ? 'text-gray-700' : 'text-gray-400'}`}>{item.label}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Main panel */}
          <div className="flex-1 min-w-0">

            {/* ── PERSONAL INFO ──────────────────────────────── */}
            {tab === 'profile' && (
              <form onSubmit={handleSaveProfile}>
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                  {/* Section: Contact */}
                  <SectionHead icon={<FiUser size={15} className="text-blue-600" />} title="Contact Information" />
                  <div className="p-5 grid sm:grid-cols-2 gap-4 border-b border-gray-100">
                    <Field label="Full Name *">
                      <div className="relative">
                        <FiUser className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input value={form.name} onChange={e => set('name', e.target.value)}
                          className="input-pl" placeholder="As per Aadhaar card" required />
                      </div>
                    </Field>
                    <Field label="Email Address">
                      <div className="relative">
                        <FiMail className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input value={user?.email || ''} readOnly
                          className="input-pl bg-gray-50 text-gray-400 cursor-not-allowed" />
                      </div>
                      <p className="text-xs text-gray-400 mt-1">Email cannot be changed</p>
                    </Field>
                    <Field label="Mobile Number">
                      <div className="relative">
                        <FiPhone className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input value={form.phone} onChange={e => set('phone', e.target.value)}
                          className="input-pl" placeholder="+91 XXXXX XXXXX" type="tel" />
                      </div>
                    </Field>
                  </div>

                  {/* Section: Personal */}
                  <SectionHead icon={<FiCalendar size={15} className="text-blue-600" />} title="Personal Details" />
                  <div className="p-5 grid sm:grid-cols-2 gap-4 border-b border-gray-100">
                    <Field label="Date of Birth">
                      <div className="relative">
                        <FiCalendar className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input type="date" value={form.dob} onChange={e => set('dob', e.target.value)}
                          className="input-pl" />
                      </div>
                    </Field>
                    <Field label="Gender">
                      <select value={form.gender} onChange={e => set('gender', e.target.value)}
                        className="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition text-gray-700">
                        <option value="">Select gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Transgender</option>
                        <option>Prefer not to say</option>
                      </select>
                    </Field>
                    <Field label="District">
                      <div className="relative">
                        <FiMapPin className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" size={14} />
                        <select value={form.district} onChange={e => set('district', e.target.value)}
                          className="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition appearance-none text-gray-700">
                          <option value="">Select district</option>
                          {DISTRICTS.map(d => <option key={d}>{d}</option>)}
                        </select>
                      </div>
                    </Field>
                    <Field label="Highest Qualification">
                      <div className="relative">
                        <FiBook className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" size={14} />
                        <select value={form.qualification} onChange={e => set('qualification', e.target.value)}
                          className="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition appearance-none text-gray-700">
                          <option value="">Select qualification</option>
                          {QUALIFICATIONS.map(q => <option key={q}>{q}</option>)}
                        </select>
                      </div>
                    </Field>
                  </div>

                  {/* Section: Skills & Address */}
                  <SectionHead icon={<FiStar size={15} className="text-blue-600" />} title="Skills & Address" />
                  <div className="p-5 space-y-4">
                    <Field label="Skills (comma separated)">
                      <div className="relative">
                        <FiStar className="absolute left-3 top-3 text-gray-400" size={14} />
                        <input value={form.skills} onChange={e => set('skills', e.target.value)}
                          className="input-pl" placeholder="e.g. Tally, MS Office, Data Entry, Driving, React…" />
                      </div>
                      {skillTags.length > 0 && (
                        <div className="flex flex-wrap gap-1.5 mt-2">
                          {skillTags.map((t, i) => (
                            <span key={i} className="bg-blue-50 text-blue-700 border border-blue-200 text-xs px-2.5 py-1 rounded-full">{t}</span>
                          ))}
                        </div>
                      )}
                    </Field>
                    <Field label="Residential Address">
                      <div className="relative">
                        <FiHome className="absolute left-3 top-3 text-gray-400" size={14} />
                        <textarea value={form.address} onChange={e => set('address', e.target.value)}
                          className="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white resize-none transition"
                          rows={2} placeholder="House No., Village/City, Punjab" />
                      </div>
                    </Field>
                  </div>

                  {/* Save button */}
                  <div className="px-5 pb-5">
                    <button type="submit" disabled={saving}
                      className="w-full py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold rounded-xl flex items-center justify-center gap-2 transition shadow-sm shadow-blue-200">
                      {saving
                        ? <><div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" /> Saving…</>
                        : <><FiSave size={15} /> Save Profile</>}
                    </button>
                  </div>
                </div>
              </form>
            )}

            {/* ── CHANGE PASSWORD ────────────────────────────── */}
            {tab === 'password' && (
              <form onSubmit={handleChangePassword}>
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                  <SectionHead icon={<FiShield size={15} className="text-blue-600" />} title="Change Password" />
                  <div className="p-5 space-y-4">
                    <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
                      <FiShield size={18} className="text-blue-600 mt-0.5 shrink-0" />
                      <div>
                        <p className="text-sm font-semibold text-blue-800">Password Security Tips</p>
                        <ul className="text-xs text-blue-700 mt-1 space-y-0.5 list-disc list-inside">
                          <li>Use at least 8 characters</li>
                          <li>Mix uppercase, numbers, and symbols</li>
                          <li>Never share your password with anyone</li>
                        </ul>
                      </div>
                    </div>

                    <Field label="Current Password *">
                      <div className="relative">
                        <FiLock className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input
                          type={showPw.current ? 'text' : 'password'}
                          value={pwForm.current_password}
                          onChange={e => setPwForm(p => ({ ...p, current_password: e.target.value }))}
                          className="input-pl pr-10"
                          placeholder="Enter your current password" />
                        <button type="button" onClick={() => setShowPw(p => ({ ...p, current: !p.current }))}
                          className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                          {showPw.current ? <FiEyeOff size={14} /> : <FiEye size={14} />}
                        </button>
                      </div>
                    </Field>

                    <Field label="New Password *">
                      <div className="relative">
                        <FiKey className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input
                          type={showPw.new ? 'text' : 'password'}
                          value={pwForm.new_password}
                          onChange={e => setPwForm(p => ({ ...p, new_password: e.target.value }))}
                          className="input-pl pr-10"
                          placeholder="At least 8 characters" />
                        <button type="button" onClick={() => setShowPw(p => ({ ...p, new: !p.new }))}
                          className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                          {showPw.new ? <FiEyeOff size={14} /> : <FiEye size={14} />}
                        </button>
                      </div>
                      {pwStrength && (
                        <div className="mt-2 space-y-1">
                          <div className="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                            <div className={`h-full rounded-full transition-all ${pwStrength.color} ${pwStrength.w}`} />
                          </div>
                          <p className={`text-xs font-medium ${
                            pwStrength.label === 'Strong' ? 'text-green-600' :
                            pwStrength.label === 'Good'   ? 'text-yellow-600' :
                            pwStrength.label === 'Fair'   ? 'text-orange-500' : 'text-red-500'
                          }`}>Password strength: {pwStrength.label}</p>
                        </div>
                      )}
                    </Field>

                    <Field label="Confirm New Password *">
                      <div className="relative">
                        <FiKey className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={14} />
                        <input
                          type={showPw.confirm ? 'text' : 'password'}
                          value={pwForm.new_password_confirmation}
                          onChange={e => setPwForm(p => ({ ...p, new_password_confirmation: e.target.value }))}
                          className={`input-pl pr-10 ${
                            pwForm.new_password_confirmation &&
                            pwForm.new_password !== pwForm.new_password_confirmation
                              ? 'border-red-300 focus:ring-red-400'
                              : pwForm.new_password_confirmation && pwForm.new_password === pwForm.new_password_confirmation
                                ? 'border-green-300 focus:ring-green-400'
                                : ''
                          }`}
                          placeholder="Repeat new password" />
                        <button type="button" onClick={() => setShowPw(p => ({ ...p, confirm: !p.confirm }))}
                          className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                          {showPw.confirm ? <FiEyeOff size={14} /> : <FiEye size={14} />}
                        </button>
                      </div>
                      {pwForm.new_password_confirmation && (
                        <p className={`text-xs mt-1 font-medium ${
                          pwForm.new_password === pwForm.new_password_confirmation ? 'text-green-600' : 'text-red-500'
                        }`}>
                          {pwForm.new_password === pwForm.new_password_confirmation ? '✓ Passwords match' : '✗ Passwords do not match'}
                        </p>
                      )}
                    </Field>

                    <button type="submit" disabled={pwSaving}
                      className="w-full py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-semibold rounded-xl flex items-center justify-center gap-2 transition shadow-sm shadow-blue-200">
                      {pwSaving
                        ? <><div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" /> Changing…</>
                        : <><FiShield size={15} /> Update Password</>}
                    </button>
                  </div>
                </div>
              </form>
            )}

            {/* ── ACCOUNT INFO ───────────────────────────────── */}
            {tab === 'account' && (
              <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <SectionHead icon={<FiInfo size={15} className="text-blue-600" />} title="Account Information" />
                <div className="p-5 space-y-3">
                  {[
                    { label: 'Full Name',      value: form.name || '—',           icon: FiUser      },
                    { label: 'Email Address',  value: user?.email || '—',         icon: FiMail      },
                    { label: 'Phone',          value: form.phone || '—',           icon: FiPhone     },
                    { label: 'Date of Birth',  value: form.dob || '—',             icon: FiCalendar  },
                    { label: 'Gender',         value: form.gender || '—',          icon: FiUser      },
                    { label: 'District',       value: form.district || '—',        icon: FiMapPin    },
                    { label: 'Qualification',  value: form.qualification || '—',   icon: FiBook      },
                    { label: 'Address',        value: form.address || '—',         icon: FiHome      },
                    { label: 'Account Status', value: 'Active',                    icon: FiCheckCircle },
                  ].map(row => (
                    <div key={row.label} className="flex items-start gap-3 py-2.5 border-b border-gray-50 last:border-0">
                      <div className="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <row.icon size={13} className="text-blue-600" />
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="text-xs text-gray-400 font-medium uppercase tracking-wide">{row.label}</p>
                        <p className="text-sm text-gray-800 font-semibold mt-0.5 truncate">{row.value}</p>
                      </div>
                    </div>
                  ))}

                  {/* Skills tags */}
                  {skillTags.length > 0 && (
                    <div className="pt-1">
                      <p className="text-xs text-gray-400 font-medium uppercase tracking-wide mb-2">Skills</p>
                      <div className="flex flex-wrap gap-1.5">
                        {skillTags.map((t, i) => (
                          <span key={i} className="bg-blue-50 text-blue-700 border border-blue-200 text-xs px-2.5 py-1 rounded-full">{t}</span>
                        ))}
                      </div>
                    </div>
                  )}

                  <div className="mt-4 pt-3 border-t border-gray-100">
                    <button onClick={() => setTab('profile')}
                      className="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl flex items-center justify-center gap-2 transition">
                      <FiEdit3 size={13} /> Edit Profile
                    </button>
                  </div>
                </div>
              </div>
            )}

          </div>
        </div>
      </div>

      {/* Inline styles for reused input class */}
      <style>{`
        .input-pl {
          width: 100%;
          border: 1px solid #e5e7eb;
          border-radius: 0.5rem;
          padding: 0.625rem 0.75rem 0.625rem 2.25rem;
          font-size: 0.875rem;
          outline: none;
          background: white;
          transition: border-color .15s, box-shadow .15s;
          color: #111827;
        }
        .input-pl:focus {
          border-color: #3b82f6;
          box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
      `}</style>
    </div>
  )
}

function SectionHead({ icon, title }) {
  return (
    <div className="flex items-center gap-2.5 px-5 py-3 bg-gray-50 border-b border-gray-100">
      <div className="w-6 h-6 bg-blue-100 rounded-md flex items-center justify-center">{icon}</div>
      <span className="text-sm font-bold text-gray-700 uppercase tracking-wide">{title}</span>
    </div>
  )
}
function Field({ label, children }) {
  return (
    <div>
      <label className="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">{label}</label>
      {children}
    </div>
  )
}
