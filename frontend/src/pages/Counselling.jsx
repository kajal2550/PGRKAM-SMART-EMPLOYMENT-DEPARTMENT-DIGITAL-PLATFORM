import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useAuth } from '../context/AuthContext'
import { userAPI } from '../api/axios'
import api from '../api/axios'
import { FiMessageSquare, FiCalendar, FiClock, FiCheckCircle, FiTrash2 } from 'react-icons/fi'
import { formatDate } from '../utils/helpers'
import toast from 'react-hot-toast'

const slots = ['10:00 AM', '11:00 AM', '12:00 PM', '2:00 PM', '3:00 PM', '4:00 PM']
const counsellors = [
  { id: 1, name: 'Dr. Rajinder Kaur',  expertise: 'Career Planning & IT',          rating: 4.9, sessions: 320 },
  { id: 2, name: 'Mr. Amandeep Singh', expertise: 'Government Jobs & UPSC Prep',   rating: 4.7, sessions: 210 },
  { id: 3, name: 'Ms. Priya Sharma',   expertise: 'Skill Development & Placement', rating: 4.8, sessions: 180 },
]

export default function Counselling() {
  const { user }   = useAuth()
  const navigate   = useNavigate()
  const [form, setForm]           = useState({ counsellor_id: '', date: '', slot: '', topic: '', notes: '' })
  const [submitting, setSubmitting] = useState(false)
  const [submitted,  setSubmitted]  = useState(false)
  const [sessions,   setSessions]   = useState([])
  const [loadingSessions, setLoadingSessions] = useState(true)

  const fetchSessions = async () => {
    if (!user) return
    try {
      const { data } = await userAPI.getCounselling()
      setSessions(data.sessions || [])
    } catch {
      // silently ignore
    } finally {
      setLoadingSessions(false)
    }
  }

  useEffect(() => { fetchSessions() }, [user])

  const handleSubmit = async (e) => {
    e.preventDefault()
    if (!user) { toast.error('Please login to book a session'); navigate('/login'); return }
    if (!form.counsellor_id || !form.date || !form.slot || !form.topic) {
      toast.error('Please fill all required fields')
      return
    }
    setSubmitting(true)
    try {
      await userAPI.bookCounselling({
        counsellor_id:  parseInt(form.counsellor_id),
        preferred_date: form.date,
        time_slot:      form.slot,
        topic:          form.topic,
        notes:          form.notes,
      })
      setSubmitted(true)
      toast.success('Counselling session booked successfully! 🎉')
      fetchSessions()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Booking failed. Please try again.')
    } finally {
      setSubmitting(false)
    }
  }

  const handleCancel = async (sessionId) => {
    try {
      await api.delete(`/counselling/${sessionId}`)
      setSessions((p) => p.map((s) => s.id === sessionId ? { ...s, status: 'cancelled' } : s))
      toast.success('Session cancelled')
    } catch {
      toast.error('Could not cancel session')
    }
  }

  return (
    <div className="max-w-4xl mx-auto space-y-8 animate-fade-in">
      <div>
        <h1 className="text-2xl font-extrabold text-gray-900">Career Counselling</h1>
        <p className="text-gray-500 text-sm mt-1">
          Book a one-on-one session with our certified career counsellors.
        </p>
      </div>

      {/* Counsellors */}
      <div>
        <h2 className="font-bold text-gray-900 mb-4">Our Counsellors</h2>
        <div className="grid sm:grid-cols-3 gap-4">
          {counsellors.map((c) => (
            <div
              key={c.id}
              onClick={() => setForm({ ...form, counsellor_id: String(c.id) })}
              className={`glass-card p-4 cursor-pointer transition-all duration-200
                          ${form.counsellor_id === String(c.id)
                            ? 'ring-2 ring-primary-500 shadow-lg'
                            : 'hover:shadow-md'}`}
            >
              <div className="w-12 h-12 rounded-full bg-primary-600 flex items-center justify-center
                              text-white font-bold text-lg mx-auto mb-3">
                {c.name.charAt(0)}
              </div>
              <p className="font-semibold text-gray-900 text-center text-sm">{c.name}</p>
              <p className="text-xs text-gray-500 text-center mt-0.5">{c.expertise}</p>
              <div className="flex justify-center gap-3 mt-2 text-xs text-gray-500">
                <span>⭐ {c.rating}</span>
                <span>💬 {c.sessions} sessions</span>
              </div>
              {form.counsellor_id === String(c.id) && (
                <p className="text-center text-xs text-primary-600 font-medium mt-2">✓ Selected</p>
              )}
            </div>
          ))}
        </div>
      </div>

      {/* Booking Form / Success */}
      {!submitted ? (
        <div className="glass-card p-6">
          <h2 className="font-bold text-gray-900 mb-5">Book a Session</h2>
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="grid sm:grid-cols-2 gap-4">
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1 block">Preferred Date *</label>
                <div className="relative">
                  <FiCalendar className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={15} />
                  <input type="date" value={form.date}
                    min={new Date().toISOString().split('T')[0]}
                    onChange={(e) => setForm({ ...form, date: e.target.value })}
                    className="input-field pl-9 text-sm" />
                </div>
              </div>
              <div>
                <label className="text-sm font-medium text-gray-700 mb-1 block">Time Slot *</label>
                <div className="flex flex-wrap gap-2">
                  {slots.map((s) => (
                    <button
                      key={s}
                      type="button"
                      onClick={() => setForm({ ...form, slot: s })}
                      className={`px-3 py-1.5 rounded-lg text-xs font-medium transition ${
                        form.slot === s
                          ? 'bg-primary-600 text-white'
                          : 'bg-gray-100 text-gray-600 hover:bg-primary-50'
                      }`}
                    >
                      {s}
                    </button>
                  ))}
                </div>
              </div>
            </div>
            <div>
              <label className="text-sm font-medium text-gray-700 mb-1 block">Topic / Query *</label>
              <input type="text" value={form.topic}
                onChange={(e) => setForm({ ...form, topic: e.target.value })}
                placeholder="e.g., Career change, Government exam prep, Resume review"
                className="input-field text-sm" />
            </div>
            <div>
              <label className="text-sm font-medium text-gray-700 mb-1 block">Additional Notes</label>
              <textarea rows={3} value={form.notes}
                onChange={(e) => setForm({ ...form, notes: e.target.value })}
                placeholder="Any specific questions or background information…"
                className="input-field text-sm resize-none" />
            </div>
            <button type="submit" disabled={submitting} className="btn-primary flex items-center gap-2">
              {submitting ? (
                <>
                  <div className="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin" />
                  Booking…
                </>
              ) : (
                <><FiMessageSquare size={15} /> Book Session</>
              )}
            </button>
          </form>
        </div>
      ) : (
        <div className="glass-card p-8 text-center animate-slide-up">
          <FiCheckCircle size={48} className="text-green-500 mx-auto mb-4" />
          <h2 className="text-xl font-bold text-gray-900 mb-2">Session Booked!</h2>
          <p className="text-gray-500 text-sm">
            Your session has been confirmed. You'll receive a reminder 30 minutes before.
          </p>
          <button onClick={() => { setSubmitted(false); setForm({ counsellor_id: '', date: '', slot: '', topic: '', notes: '' }) }}
            className="btn-secondary mt-6 text-sm">
            Book Another
          </button>
        </div>
      )}

      {/* My Sessions */}
      <div className="glass-card p-6">
        <h2 className="font-bold text-gray-900 mb-4">My Booked Sessions</h2>
        {loadingSessions ? (
          <div className="flex justify-center py-8">
            <div className="w-6 h-6 border-4 border-primary-200 border-t-primary-600 rounded-full animate-spin" />
          </div>
        ) : sessions.length === 0 ? (
          <p className="text-gray-400 text-sm">No sessions booked yet.</p>
        ) : (
          <div className="space-y-3">
            {sessions.map((r) => (
              <div key={r.id} className="flex items-center gap-4 p-3 rounded-xl bg-gray-50">
                <div className="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                  <FiMessageSquare className="text-primary-600" size={18} />
                </div>
                <div className="flex-1 min-w-0">
                  <p className="font-medium text-gray-800 text-sm">{r.counsellor_name}</p>
                  <p className="text-xs text-gray-500">{r.topic} · {formatDate(r.preferred_date)} · {r.time_slot}</p>
                </div>
                <span className={`badge flex-shrink-0 ${
                  r.status === 'confirmed'  ? 'badge-green'  :
                  r.status === 'cancelled'  ? 'badge-red'    : 'badge-yellow'
                }`}>
                  {r.status}
                </span>
                {r.status !== 'cancelled' && (
                  <button
                    onClick={() => handleCancel(r.id)}
                    className="p-1.5 text-gray-400 hover:text-red-500 transition rounded"
                    title="Cancel session"
                  >
                    <FiTrash2 size={14} />
                  </button>
                )}
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  )
}
