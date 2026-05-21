import { useState, useEffect, useCallback } from 'react'
import { useNavigate, Link } from 'react-router-dom'
import {
  FiSearch, FiMapPin, FiBriefcase, FiClock, FiDollarSign,
  FiBookmark, FiCheckCircle, FiX, FiUser, FiPhone, FiFileText,
  FiHash, FiFilter, FiCalendar, FiUsers, FiAward,
} from 'react-icons/fi'
import { jobsAPI } from '../api/axios'
import { useAuth } from '../context/AuthContext'
import { formatDate } from '../utils/helpers'
import toast from 'react-hot-toast'

const jobTypes = ['All', 'Government', 'Private']
const locations = ['All', 'Chandigarh', 'Mohali', 'Ludhiana', 'Amritsar', 'Patiala']

const alreadyAppliedToast = () =>
  toast('Already applied for this job!', {
    style: { background: '#eff6ff', color: '#1d4ed8', border: '1.5px solid #bfdbfe', borderRadius: '14px', padding: '14px 18px', fontSize: '14px', fontWeight: '500', boxShadow: '0 8px 32px rgba(37,99,235,0.12)', maxWidth: '380px' },
  })

const alreadySavedToast = () =>
  toast('Already saved to your list!', {
    style: { background: '#eff6ff', color: '#1d4ed8', border: '1.5px solid #bfdbfe', borderRadius: '14px', padding: '14px 18px', fontSize: '14px', fontWeight: '500', boxShadow: '0 8px 32px rgba(37,99,235,0.12)', maxWidth: '380px' },
  })

export default function Jobs() {
  const { user } = useAuth()
  const navigate = useNavigate()

  const [jobs,       setJobs]       = useState([])
  const [loading,    setLoading]    = useState(true)
  const [search,     setSearch]     = useState('')
  const [type,       setType]       = useState('All')
  const [loc,        setLoc]        = useState('All')
  const [saved,      setSaved]      = useState({})
  const [applied,    setApplied]    = useState({})
  const [actioning,  setActioning]  = useState({})

  const [applyingJob, setApplyingJob] = useState(null)
  const [appForm,     setAppForm]     = useState({ applicant_name: '', phone: '', experience: 'Fresher', qualification: '', cover_letter: '' })
  const [submitting,  setSubmitting]  = useState(false)
  const [successRef,  setSuccessRef]  = useState(null)

  const fetchJobs = useCallback(async () => {
    setLoading(true)
    try {
      const params = {}
      if (type !== 'All') params.type     = type.toLowerCase()
      if (loc  !== 'All') params.location = loc
      if (search.trim())  params.search   = search.trim()
      const { data } = await jobsAPI.getAll(params)
      setJobs(data.data || data)
    } catch {
      toast.error('Failed to load jobs. Please try again.')
    } finally {
      setLoading(false)
    }
  }, [type, loc, search])

  useEffect(() => {
    const t = setTimeout(fetchJobs, 400)
    return () => clearTimeout(t)
  }, [fetchJobs])

  const handleSave = async (e, jobId) => {
    e.stopPropagation()
    if (!user) { toast.error('Please login to save jobs'); navigate('/login'); return }
    setActioning((p) => ({ ...p, [jobId]: 'save' }))
    try {
      await jobsAPI.saveJob(jobId)
      setSaved((p) => ({ ...p, [jobId]: true }))
      toast.success('Job saved to your list!')
    } catch (err) {
      if (err.response?.status === 409) { setSaved((p) => ({ ...p, [jobId]: true })); alreadySavedToast() }
      else toast.error('Could not save job')
    } finally {
      setActioning((p) => ({ ...p, [jobId]: null }))
    }
  }

  const openApplyModal = (e, job) => {
    e.stopPropagation()
    if (!user) { toast.error('Please login to apply'); navigate('/login'); return }
    if (applied[job.id]) { alreadyAppliedToast(); return }
    setAppForm({ applicant_name: user.name || '', phone: user.phone || '', experience: 'Fresher', qualification: '', cover_letter: '' })
    setApplyingJob(job)
  }

  const submitApplication = async (e) => {
    e.preventDefault()
    if (!appForm.applicant_name.trim()) { toast.error('Please enter your name'); return }
    if (!appForm.phone.trim())          { toast.error('Please enter your phone number'); return }
    if (!appForm.qualification.trim())  { toast.error('Please select your qualification'); return }
    setSubmitting(true)
    try {
      const { data } = await jobsAPI.applyJob(applyingJob.id, appForm)
      setApplied((p) => ({ ...p, [applyingJob.id]: true }))
      setSuccessRef({ ref: data.application_ref, jobTitle: applyingJob.title })
      setApplyingJob(null)
    } catch (err) {
      if (err.response?.status === 409) {
        setApplied((p) => ({ ...p, [applyingJob.id]: true }))
        alreadyAppliedToast()
        setApplyingJob(null)
      } else if (err.response?.status === 422) {
        const errors = err.response.data.errors
        toast.error(Object.values(errors)[0]?.[0] || 'Please fill all required fields')
      } else {
        toast.error(err.response?.data?.message || 'Submission failed. Please try again.')
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
                Punjab Government & Private Sector
              </span>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-3">Job Listings</h1>
              <p className="text-white/70 text-lg max-w-xl">
                Discover government and private sector opportunities across all 23 districts of Punjab.
              </p>
            </div>
            <div className="flex gap-4 flex-shrink-0">
              {[
                { icon: FiBriefcase, val: `${jobs.length}+`, lbl: 'Open Positions' },
                { icon: FiUsers,     val: 'Free',            lbl: 'To Apply'       },
                { icon: FiAward,     val: '23',              lbl: 'Districts'      },
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
              placeholder="Search job title or department…"
              className="w-full border border-gray-200 dark:border-gray-600 rounded-xl pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition"
            />
          </div>
          <div className="flex items-center gap-2 flex-wrap">
            <FiFilter size={14} className="text-gray-400" />
            {jobTypes.map((t) => (
              <button key={t} onClick={() => setType(t)}
                className={`px-4 py-2 rounded-xl text-xs font-semibold transition-all ${
                  type === t
                    ? 'bg-primary-600 text-white shadow-md shadow-primary-200 dark:shadow-none'
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900/30 hover:text-primary-700'
                }`}>
                {t}
              </button>
            ))}
          </div>
          <select value={loc} onChange={(e) => setLoc(e.target.value)}
            className="border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-400 transition w-full sm:w-40">
            {locations.map((l) => <option key={l}>{l}</option>)}
          </select>
        </div>
      </section>

      {/* ── Results ───────────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 pb-16">

        {/* Results count */}
        {!loading && (
          <p className="text-sm text-gray-500 dark:text-gray-400 mb-4">
            Showing <span className="font-semibold text-gray-800 dark:text-gray-200">{jobs.length}</span> job{jobs.length !== 1 ? 's' : ''}
            {type !== 'All' && <span> · {type}</span>}
            {loc  !== 'All' && <span> · {loc}</span>}
          </p>
        )}

        {/* Loading skeleton */}
        {loading && (
          <div className="space-y-4">
            {[1,2,3,4].map(i => (
              <div key={i} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 animate-pulse">
                <div className="flex gap-4">
                  <div className="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-2xl flex-shrink-0" />
                  <div className="flex-1 space-y-2">
                    <div className="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/3" />
                    <div className="h-3 bg-gray-100 dark:bg-gray-600 rounded w-1/4" />
                    <div className="h-3 bg-gray-100 dark:bg-gray-600 rounded w-1/2" />
                  </div>
                  <div className="w-24 h-9 bg-gray-100 dark:bg-gray-700 rounded-xl" />
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Empty state */}
        {!loading && jobs.length === 0 && (
          <div className="text-center py-24">
            <div className="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
              <FiBriefcase size={36} className="text-gray-300 dark:text-gray-600" />
            </div>
            <p className="text-gray-500 dark:text-gray-400 font-medium">No jobs match your filters.</p>
            <p className="text-gray-400 dark:text-gray-500 text-sm mt-1">Try a different location or job type.</p>
          </div>
        )}

        {/* Job cards */}
        {!loading && jobs.length > 0 && (
          <div className="space-y-4">
            {jobs.map((job) => {
              const isGovt = job.type === 'government'
              return (
                <div key={job.id}
                  className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">

                  {/* colored left accent bar */}
                  <div className={`h-1 w-full ${isGovt ? 'bg-primary-600' : 'bg-primary-400'}`} />

                  <div className="p-5">
                    {/* Top row */}
                    <div className="flex flex-col sm:flex-row sm:items-start gap-4">
                      {/* Icon */}
                      <div className={`w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 ${isGovt ? 'bg-primary-100 dark:bg-primary-900/40' : 'bg-blue-50 dark:bg-blue-900/30'}`}>
                        <FiBriefcase className={isGovt ? 'text-primary-700 dark:text-primary-400' : 'text-blue-500'} size={22} />
                      </div>

                      {/* Info */}
                      <div className="flex-1 min-w-0">
                        <div className="flex items-start justify-between gap-2 flex-wrap">
                          <h3 className="font-extrabold text-gray-900 dark:text-white text-lg leading-snug">{job.title}</h3>
                          <span className={`text-xs font-semibold px-3 py-1 rounded-full flex-shrink-0 ${
                            isGovt
                              ? 'bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400'
                              : 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                          }`}>
                            {isGovt ? '🏛 Government' : '🏢 Private'}
                          </span>
                        </div>
                        <p className="text-gray-500 dark:text-gray-400 text-sm mt-0.5 font-medium">{job.department}</p>

                        {/* Meta chips */}
                        <div className="flex flex-wrap gap-2 mt-3">
                          <span className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1.5 rounded-lg">
                            <FiMapPin size={11} /> {job.location}
                          </span>
                          {job.salary_range && (
                            <span className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1.5 rounded-lg">
                              <FiDollarSign size={11} /> {job.salary_range}
                            </span>
                          )}
                          <span className="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 px-2.5 py-1.5 rounded-lg">
                            <FiClock size={11} /> Deadline: {formatDate(job.application_deadline)}
                          </span>
                          {job.vacancies && (
                            <span className="flex items-center gap-1.5 text-xs font-semibold bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 px-2.5 py-1.5 rounded-lg">
                              <FiUsers size={11} /> {job.vacancies} Vacancies
                            </span>
                          )}
                        </div>
                      </div>

                      {/* Action buttons */}
                      <div className="flex gap-2 flex-shrink-0 items-center">
                        <button onClick={(e) => handleSave(e, job.id)} disabled={!!actioning[job.id]}
                          className={`p-2.5 rounded-xl border-2 transition-all ${
                            saved[job.id]
                              ? 'bg-primary-50 dark:bg-primary-900/30 border-primary-300 text-primary-600'
                              : 'border-gray-200 dark:border-gray-600 text-gray-400 hover:border-primary-300 hover:text-primary-600'
                          }`} title="Save Job">
                          <FiBookmark size={16} className={saved[job.id] ? 'fill-current' : ''} />
                        </button>
                        <button onClick={(e) => openApplyModal(e, job)} disabled={!!actioning[job.id] || !!applied[job.id]}
                          className={`px-5 py-2.5 rounded-xl text-sm font-semibold transition-all ${
                            applied[job.id]
                              ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 cursor-default'
                              : 'bg-primary-600 hover:bg-primary-700 text-white shadow-md shadow-primary-200 dark:shadow-none'
                          }`}>
                          {applied[job.id]
                            ? <span className="flex items-center gap-1.5"><FiCheckCircle size={14} /> Applied</span>
                            : 'Apply Now →'}
                        </button>
                      </div>
                    </div>

                    {/* Details section */}
                    <div className="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                      <div className="grid sm:grid-cols-2 gap-3 text-sm text-gray-600 dark:text-gray-400">
                        {job.posted_on && (
                          <p className="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/40 rounded-xl px-3 py-2">
                            <FiCalendar size={13} className="text-primary-500 flex-shrink-0" />
                            Posted: <span className="font-medium text-gray-800 dark:text-gray-200">{formatDate(job.posted_on)}</span>
                          </p>
                        )}
                        {job.vacancies && (
                          <p className="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/40 rounded-xl px-3 py-2">
                            <FiUsers size={13} className="text-primary-500 flex-shrink-0" />
                            Vacancies: <span className="font-medium text-gray-800 dark:text-gray-200">{job.vacancies}</span>
                          </p>
                        )}
                      </div>
                      <p className="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {job.description || `This is a ${job.type} sector position with the ${job.department}. Candidates meeting eligibility criteria may apply before ${formatDate(job.application_deadline)}.`}
                      </p>
                      {job.qualifications && Array.isArray(job.qualifications) && job.qualifications.length > 0 && (
                        <div className="mt-3">
                          <p className="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Qualifications Required</p>
                          <div className="flex flex-wrap gap-2">
                            {job.qualifications.map((q, i) => (
                              <span key={i} className="text-xs bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 px-2.5 py-1 rounded-lg">
                                {q}
                              </span>
                            ))}
                          </div>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              )
            })}
          </div>
        )}
      </section>
    </div>

    {/* ── Apply Modal ───────────────────────────────────────────────────── */}
    {applyingJob && (
      <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

          <div className="bg-gradient-to-r from-primary-600 to-primary-800 rounded-t-2xl p-6 flex items-start justify-between">
            <div>
              <p className="text-white/70 text-xs font-semibold uppercase tracking-wide mb-1">Applying for</p>
              <h2 className="text-xl font-extrabold text-white">{applyingJob.title}</h2>
              <p className="text-white/70 text-sm mt-1">{applyingJob.department}</p>
            </div>
            <button onClick={() => setApplyingJob(null)}
              className="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition flex-shrink-0 mt-1">
              <FiX size={16} className="text-white" />
            </button>
          </div>

          <form onSubmit={submitApplication} className="p-6 space-y-4">
            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full Name <span className="text-red-500">*</span></label>
              <div className="relative">
                <FiUser className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={15} />
                <input type="text" value={appForm.applicant_name}
                  onChange={(e) => setAppForm(p => ({ ...p, applicant_name: e.target.value }))}
                  placeholder="Enter your full name"
                  className="w-full border border-gray-200 dark:border-gray-600 rounded-xl pl-9 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required />
              </div>
            </div>

            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Phone Number <span className="text-red-500">*</span></label>
              <div className="relative">
                <FiPhone className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={15} />
                <input type="tel" value={appForm.phone}
                  onChange={(e) => setAppForm(p => ({ ...p, phone: e.target.value }))}
                  placeholder="Enter your 10-digit mobile number"
                  className="w-full border border-gray-200 dark:border-gray-600 rounded-xl pl-9 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required />
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Experience <span className="text-red-500">*</span></label>
                <select value={appForm.experience}
                  onChange={(e) => setAppForm(p => ({ ...p, experience: e.target.value }))}
                  className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required>
                  <option>Fresher</option>
                  <option>Less than 1 year</option>
                  <option>1-2 years</option>
                  <option>2-5 years</option>
                  <option>5-10 years</option>
                  <option>10+ years</option>
                </select>
              </div>
              <div>
                <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Qualification <span className="text-red-500">*</span></label>
                <select value={appForm.qualification}
                  onChange={(e) => setAppForm(p => ({ ...p, qualification: e.target.value }))}
                  className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition" required>
                  <option value="">Select</option>
                  <option>10th Pass</option>
                  <option>12th Pass</option>
                  <option>ITI / Diploma</option>
                  <option>Graduate (B.A/B.Sc/B.Com)</option>
                  <option>Graduate (B.Tech/BE)</option>
                  <option>Post Graduate</option>
                  <option>PhD</option>
                </select>
              </div>
            </div>

            <div>
              <label className="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                <span className="flex items-center gap-1.5"><FiFileText size={14} /> Cover Letter <span className="text-gray-400 font-normal">(Optional)</span></span>
              </label>
              <textarea value={appForm.cover_letter}
                onChange={(e) => setAppForm(p => ({ ...p, cover_letter: e.target.value }))}
                rows={4} placeholder="Briefly describe your skills and why you're suitable for this position…"
                className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent resize-none transition" />
            </div>

            <div className="bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-xl p-3 text-sm text-primary-700 dark:text-primary-400 flex items-start gap-2">
              <FiCheckCircle size={15} className="flex-shrink-0 mt-0.5" />
              Your application will be sent to <strong>{applyingJob.department}</strong>. They will contact you if shortlisted.
            </div>

            <div className="flex gap-3">
              <button type="button" onClick={() => setApplyingJob(null)}
                className="flex-1 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
                Cancel
              </button>
              <button type="submit" disabled={submitting}
                className="flex-1 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold flex items-center justify-center gap-2 transition text-sm shadow-lg shadow-primary-200 dark:shadow-none disabled:opacity-70">
                {submitting
                  ? <><div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" /> Submitting…</>
                  : 'Submit Application'}
              </button>
            </div>
          </form>
        </div>
      </div>
    )}

    {/* ── Success Modal ─────────────────────────────────────────────────── */}
    {successRef && (
      <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-8 text-center">
          <div className="w-20 h-20 bg-primary-100 dark:bg-primary-900/40 rounded-full flex items-center justify-center mx-auto mb-5">
            <FiCheckCircle size={40} className="text-primary-600" />
          </div>
          <h2 className="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">Application Submitted!</h2>
          <p className="text-gray-500 dark:text-gray-400 text-sm mb-5">
            Your application for <span className="font-semibold text-gray-700 dark:text-gray-300">{successRef.jobTitle}</span> has been received.
          </p>
          <div className="bg-primary-50 dark:bg-primary-900/30 border border-primary-200 dark:border-primary-700 rounded-2xl p-4 mb-6">
            <p className="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1 flex items-center justify-center gap-1">
              <FiHash size={12} /> Application Reference
            </p>
            <p className="text-2xl font-mono font-extrabold text-primary-700 dark:text-primary-400 select-all">{successRef.ref}</p>
            <p className="text-xs text-gray-400 dark:text-gray-500 mt-1">Save this number to track your application</p>
          </div>
          <div className="flex gap-3">
            <button onClick={() => setSuccessRef(null)}
              className="flex-1 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm">
              Browse More Jobs
            </button>
            <Link to="/my-applications" onClick={() => setSuccessRef(null)}
              className="flex-1 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition text-center text-sm shadow-lg shadow-primary-200 dark:shadow-none">
              My Applications
            </Link>
          </div>
        </div>
      </div>
    )}
    </>
  )
}