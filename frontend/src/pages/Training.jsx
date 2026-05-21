import { useState, useEffect, useCallback } from 'react'
import { useNavigate } from 'react-router-dom'
import {
  FiSearch, FiBookOpen, FiClock, FiUsers, FiCheckCircle,
  FiX, FiPhone, FiFilter, FiAward, FiTrendingUp, FiStar,
} from 'react-icons/fi'
import { trainingAPI } from '../api/axios'
import { useAuth } from '../context/AuthContext'
import toast from 'react-hot-toast'

const categories = ['All', 'IT', 'Electrical', 'Marketing', 'Handcraft', 'Communication']

const CAT_COLORS = {
  IT:            { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-blue-600',      icon: 'bg-blue-100 text-blue-700'    },
  Electrical:    { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-blue-500',      icon: 'bg-blue-100 text-blue-700'    },
  Marketing:     { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-primary-600',   icon: 'bg-blue-100 text-blue-700'    },
  Handcraft:     { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-primary-700',   icon: 'bg-blue-100 text-blue-700'    },
  Communication: { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-primary-800',   icon: 'bg-blue-100 text-blue-700'    },
  default:       { badge: 'bg-blue-100 text-blue-700',    bar: 'bg-primary-600',   icon: 'bg-blue-100 text-blue-700'    },
}

const alreadyEnrolledToast = () =>
  toast('Already enrolled in this program!', {
    style: { background: '#eff6ff', color: '#1d4ed8', border: '1.5px solid #bfdbfe', borderRadius: '14px', padding: '14px 18px', fontSize: '14px', fontWeight: '500', boxShadow: '0 8px 32px rgba(37,99,235,0.12)', maxWidth: '380px' },
  })

export default function Training() {
  const { user }    = useAuth()
  const navigate    = useNavigate()

  const [trainings, setTrainings] = useState([])
  const [loading,   setLoading]   = useState(true)
  const [search,    setSearch]    = useState('')
  const [cat,       setCat]       = useState('All')
  const [enrolled,  setEnrolled]  = useState({})

  const [enrollingItem, setEnrollingItem] = useState(null)
  const [enrollForm,    setEnrollForm]    = useState({ phone: '', qualification: '', notes: '', preferred_timing: 'Morning' })
  const [submitting,    setSubmitting]    = useState(false)

  const fetchTrainings = useCallback(async () => {
    setLoading(true)
    try {
      const params = {}
      if (cat !== 'All')  params.category = cat
      if (search.trim()) params.search   = search.trim()
      const { data } = await trainingAPI.getAll(params)
      setTrainings(data.data || data)
    } catch {
      toast.error('Failed to load training programs')
    } finally {
      setLoading(false)
    }
  }, [cat, search])

  useEffect(() => {
    const t = setTimeout(fetchTrainings, 400)
    return () => clearTimeout(t)
  }, [fetchTrainings])

  const openEnrollModal = (id) => {
    if (!user) { toast.error('Please login to enroll'); navigate('/login'); return }
    if (enrolled[id]) { alreadyEnrolledToast(); return }
    const training = trainings.find(t => t.id === id)
    setEnrollForm({ phone: user.phone || '', qualification: '', notes: '', preferred_timing: 'Morning' })
    setEnrollingItem(training)
  }

  const submitEnrollment = async (e) => {
    e.preventDefault()
    if (!enrollForm.phone.trim())         { toast.error('Please enter your phone number'); return }
    if (!enrollForm.qualification.trim()) { toast.error('Please select your qualification'); return }
    setSubmitting(true)
    try {
      await trainingAPI.enroll(enrollingItem.id, enrollForm)
      setEnrolled((p) => ({ ...p, [enrollingItem.id]: true }))
      setTrainings((prev) =>
        prev.map((t) => t.id === enrollingItem.id ? { ...t, enrolled_count: (t.enrolled_count || 0) + 1 } : t)
      )
      toast.success('Enrolled successfully! You will be contacted with batch details.')
      setEnrollingItem(null)
    } catch (err) {
      if (err.response?.status === 409) {
        setEnrolled((p) => ({ ...p, [enrollingItem.id]: true }))
        alreadyEnrolledToast()
        setEnrollingItem(null)
      } else if (err.response?.status === 422) {
        const errors = err.response.data.errors
        const first = Object.values(errors)[0]
        toast.error(first?.[0] || 'Please fill all required fields')
      } else {
        toast.error(err.response?.data?.message || 'Enrollment failed. Please try again.')
      }
    } finally {
      setSubmitting(false)
    }
  }

  return (
    <>
    <div className="bg-white dark:bg-gray-950 min-h-screen">

      {/* ── Hero ──────────────────────────────────────────────────────────── */}
      <section className="relative bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 py-16 px-6 overflow-hidden">
        <div className="absolute -top-12 -right-12 w-72 h-72 rounded-full bg-white/5 pointer-events-none" />
        <div className="absolute bottom-0 left-0 w-52 h-52 rounded-full bg-white/5 pointer-events-none" />
        <div className="relative max-w-screen-xl mx-auto">
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
              <span className="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-4 tracking-wide uppercase">
                Government of Punjab — Free Skill Development
              </span>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-3">Skill Training Programs</h1>
              <p className="text-white/70 text-lg max-w-xl">
                Free and subsidised skill development programs by the Government of Punjab — enroll today and boost your career.
              </p>
            </div>
            <div className="flex gap-4 flex-shrink-0">
              {[
                { icon: FiBookOpen,   val: `${trainings.length}+`, lbl: 'Programs' },
                { icon: FiUsers,      val: 'Free',                 lbl: 'For All'  },
                { icon: FiAward,      val: 'Govt.',                lbl: 'Certified'},
              ].map(({ icon: Icon, val, lbl }) => (
                <div key={lbl} className="bg-white/10 rounded-2xl px-5 py-4 text-center">
                  <Icon className="text-white mx-auto mb-1" size={22} />
                  <p className="text-xl font-extrabold text-white leading-none">{val}</p>
                  <p className="text-white/60 text-xs mt-0.5">{lbl}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── Filters ───────────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-6">
        <div className="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-4 flex flex-col sm:flex-row gap-3 items-center">
          <div className="relative flex-1 w-full">
            <FiSearch className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
            <input
              type="text" value={search}
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Search training programs..."
                    className="w-full border border-gray-200 dark:border-gray-600 rounded-xl pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition"
            />
          </div>
          <div className="flex items-center gap-2 flex-wrap">
            <FiFilter size={14} className="text-gray-400" />
            {categories.map((c) => (
              <button key={c} onClick={() => setCat(c)}
                className={`px-4 py-2 rounded-xl text-xs font-semibold transition-all ${
                  cat === c
                    ? 'bg-primary-600 text-white shadow-md shadow-primary-200 dark:shadow-none'
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-700'
                }`}>
                {c}
              </button>
            ))}
          </div>
        </div>
      </section>

      {/* ── Cards ─────────────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 pb-16">

        {loading && (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {[1,2,3,4,5,6].map(i => (
              <div key={i} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 animate-pulse">
                <div className="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-2xl mb-4" />
                <div className="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2" />
                <div className="h-3 bg-gray-100 dark:bg-gray-600 rounded w-1/2 mb-4" />
                <div className="h-2 bg-gray-100 dark:bg-gray-600 rounded mb-4" />
                <div className="h-10 bg-gray-100 dark:bg-gray-700 rounded-xl" />
              </div>
            ))}
          </div>
        )}

        {!loading && trainings.length === 0 && (
          <div className="text-center py-24">
            <div className="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
              <FiBookOpen size={36} className="text-gray-300 dark:text-gray-600" />
            </div>
            <p className="text-gray-500 dark:text-gray-400 font-medium">No training programs found.</p>
            <p className="text-gray-400 dark:text-gray-500 text-sm mt-1">Try a different category or search term.</p>
          </div>
        )}

        {!loading && trainings.length > 0 && (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {trainings.map((t) => {
              const isEnrolled = enrolled[t.id]
              const isFull     = t.enrolled_count >= t.total_seats
              const pct        = t.total_seats > 0 ? Math.min(100, Math.round((t.enrolled_count / t.total_seats) * 100)) : 0
              const colors     = CAT_COLORS[t.category] || CAT_COLORS.default

              return (
                <div key={t.id}
                  className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col">

                  {/* Card top accent */}
                  <div className={`h-1.5 w-full ${colors.bar}`} />

                  <div className="p-6 flex flex-col gap-4 flex-1">
                    {/* Icon + badge */}
                    <div className="flex items-center justify-between">
                      <div className={`w-12 h-12 rounded-2xl ${colors.icon} flex items-center justify-center`}>
                        <FiBookOpen size={22} />
                      </div>
                      <span className={`text-xs font-semibold px-3 py-1 rounded-full ${colors.badge}`}>{t.category}</span>
                    </div>

                    {/* Title + provider */}
                    <div>
                      <h3 className="font-extrabold text-gray-900 dark:text-white text-base leading-snug">{t.title}</h3>
                      <p className="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{t.provider}</p>
                    </div>

                    {/* Meta row */}
                    <div className="flex flex-wrap gap-3">
                      <span className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1.5 rounded-lg">
                        <FiClock size={12} /> {t.duration}
                      </span>
                      <span className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1.5 rounded-lg">
                        <FiUsers size={12} /> {t.enrolled_count}/{t.total_seats} seats
                      </span>
                      <span className={`flex items-center gap-1 text-xs font-bold px-2.5 py-1.5 rounded-lg ${
                        t.fee === 'Free' || t.fee === '₹0'
                          ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400'
                          : 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400'
                      }`}>
                        <FiStar size={11} /> {t.fee}
                      </span>
                    </div>

                    {/* Seat progress */}
                    <div>
                      <div className="flex justify-between text-xs text-gray-400 mb-1.5">
                        <span>Seats filled</span>
                        <span className={pct >= 90 ? 'text-red-500 font-semibold' : ''}>{pct}%</span>
                      </div>
                      <div className="h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div
                          className={`h-full rounded-full transition-all ${isFull ? 'bg-red-500' : pct >= 80 ? 'bg-orange-400' : colors.bar}`}
                          style={{ width: `${pct}%` }}
                        />
                      </div>
                      {isFull && <p className="text-xs text-red-500 font-medium mt-1">All seats filled</p>}
                      {!isFull && pct >= 80 && <p className="text-xs text-orange-500 font-medium mt-1">Hurry! Only {t.total_seats - t.enrolled_count} seats left</p>}
                    </div>

                    {/* Enroll button */}
                    <button
                      onClick={() => openEnrollModal(t.id)}
                      disabled={isFull || isEnrolled}
                      className={`mt-auto w-full py-2.5 rounded-xl font-semibold text-sm flex items-center justify-center gap-2 transition-all ${
                        isEnrolled
                          ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 cursor-default'
                          : isFull
                            ? 'bg-gray-100 dark:bg-gray-700 text-gray-400 cursor-not-allowed'
                            : 'bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-200 dark:shadow-none'
                      }`}>
                      {isEnrolled ? <><FiCheckCircle size={15} /> Enrolled</> : isFull ? 'No Seats Available' : 'Enroll Now →'}
                    </button>
                  </div>
                </div>
              )
            })}
          </div>
        )}
      </section>
    </div>

    {/* ── Enrollment Modal ──────────────────────────────────────────────── */}
    {enrollingItem && (
      <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">

          {/* Modal header */}
          <div className="bg-gradient-to-r from-primary-600 to-primary-800 rounded-t-2xl p-6 flex items-start justify-between">
            <div>
              <p className="text-white/70 text-xs font-semibold uppercase tracking-wide mb-1">Enrolling in</p>
              <h2 className="text-xl font-extrabold text-white">{enrollingItem.title}</h2>
              <p className="text-white/70 text-sm mt-1">{enrollingItem.provider} &bull; {enrollingItem.duration}</p>
            </div>
            <button onClick={() => setEnrollingItem(null)}
              className="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition flex-shrink-0 mt-1">
              <FiX size={16} className="text-white" />
            </button>
          </div>

          <form onSubmit={submitEnrollment} className="p-6 space-y-4">
            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Phone Number <span className="text-red-500">*</span>
              </label>
              <div className="relative">
                <FiPhone className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={15} />
                <input type="tel" value={enrollForm.phone}
                  onChange={(e) => setEnrollForm(p => ({ ...p, phone: e.target.value }))}
                  placeholder="Enter your 10-digit mobile number"
                  className="w-full border border-gray-200 dark:border-gray-600 rounded-xl pl-9 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required />
              </div>
            </div>

            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Highest Qualification <span className="text-red-500">*</span>
              </label>
              <select value={enrollForm.qualification}
                onChange={(e) => setEnrollForm(p => ({ ...p, qualification: e.target.value }))}
                className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required>
                <option value="">Select your qualification</option>
                <option>Below 10th</option>
                <option>10th Pass</option>
                <option>12th Pass</option>
                <option>ITI / Diploma</option>
                <option>Graduate</option>
                <option>Post Graduate</option>
              </select>
            </div>

            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Preferred Batch Timing <span className="text-red-500">*</span>
              </label>
              <div className="grid grid-cols-3 gap-2">
                {['Morning', 'Afternoon', 'Evening'].map((tm) => (
                  <button key={tm} type="button"
                    onClick={() => setEnrollForm(p => ({ ...p, preferred_timing: tm }))}
                    className={`py-2.5 rounded-xl text-sm font-semibold border-2 transition ${
                      enrollForm.preferred_timing === tm
                        ? 'bg-primary-600 text-white border-primary-600'
                        : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-primary-400'
                    }`}>
                    {tm}
                  </button>
                ))}
              </div>
            </div>

            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                Why are you interested? <span className="text-gray-400 font-normal">(Optional)</span>
              </label>
              <textarea value={enrollForm.notes}
                onChange={(e) => setEnrollForm(p => ({ ...p, notes: e.target.value }))}
                rows={3} placeholder="Briefly mention your goal or reason for joining…"
                className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent resize-none transition" />
            </div>

            <div className="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-xl p-3 text-sm text-primary-700 dark:text-primary-400 flex items-start gap-2">
              <FiCheckCircle size={15} className="flex-shrink-0 mt-0.5" />
              You will receive batch details and joining instructions on your registered mobile number.
            </div>

            <div className="flex gap-3">
              <button type="button" onClick={() => setEnrollingItem(null)}
                className="flex-1 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Cancel
              </button>
              <button type="submit" disabled={submitting}
                className="flex-1 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold flex items-center justify-center gap-2 transition text-sm shadow-lg shadow-primary-200 dark:shadow-none disabled:opacity-70">
                {submitting ? (
                  <><div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" /> Enrolling…</>
                ) : 'Confirm Enrollment'}
              </button>
            </div>
          </form>
        </div>
      </div>
    )}
    </>
  )
}
