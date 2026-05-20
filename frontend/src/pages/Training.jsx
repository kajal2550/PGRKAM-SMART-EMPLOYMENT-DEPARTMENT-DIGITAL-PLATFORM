import { useState } from 'react'
import { FiSearch, FiBookOpen, FiClock, FiUsers, FiCheckCircle } from 'react-icons/fi'
import { dummyTrainings } from '../utils/helpers'
import toast from 'react-hot-toast'

const categories = ['All', 'IT', 'Electrical', 'Marketing', 'Handcraft', 'Communication']

export default function Training() {
  const [search, setSearch] = useState('')
  const [cat,    setCat]    = useState('All')
  const [enrolled, setEnrolled] = useState([])

  const filtered = dummyTrainings.filter((t) => {
    const matchSearch = t.title.toLowerCase().includes(search.toLowerCase())
    const matchCat    = cat === 'All' || t.category === cat
    return matchSearch && matchCat
  })

  const handleEnroll = (id) => {
    if (enrolled.includes(id)) { toast('Already enrolled!'); return }
    setEnrolled([...enrolled, id])
    toast.success('Successfully enrolled in training!')
  }

  return (
    <div className="max-w-screen-xl mx-auto px-6 py-10">
      {/* Header */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">Skill Training Programs</h1>
        <p className="text-gray-500 mt-1">
          Free and subsidised skill development programs by the Government of Punjab.
        </p>
      </div>

      {/* Filters */}
      <div className="glass-card p-4 mb-6 flex flex-col sm:flex-row gap-3">
        <div className="relative flex-1">
          <FiSearch className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" size={16} />
          <input
            type="text"
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            placeholder="Search training programs…"
            className="input-field pl-9 text-sm"
          />
        </div>
        <div className="flex flex-wrap gap-2">
          {categories.map((c) => (
            <button
              key={c}
              onClick={() => setCat(c)}
              className={`px-3 py-1.5 rounded-lg text-xs font-medium transition ${
                cat === c
                  ? 'bg-primary-600 text-white'
                  : 'bg-gray-100 text-gray-600 hover:bg-primary-50 hover:text-primary-700'
              }`}
            >
              {c}
            </button>
          ))}
        </div>
      </div>

      {/* Cards */}
      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {filtered.map((t) => {
          const isEnrolled  = enrolled.includes(t.id)
          const isFull      = t.enrolled >= t.seats
          const pct         = Math.round((t.enrolled / t.seats) * 100)

          return (
            <div key={t.id} className="glass-card p-6 flex flex-col gap-4 animate-slide-up">
              {/* Icon */}
              <div className="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center">
                <FiBookOpen className="text-green-600" size={22} />
              </div>

              {/* Info */}
              <div>
                <div className="flex items-start justify-between gap-2">
                  <h3 className="font-bold text-gray-900">{t.title}</h3>
                  <span className="badge badge-green flex-shrink-0">{t.category}</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">{t.provider}</p>
              </div>

              {/* Meta */}
              <div className="flex gap-4 text-xs text-gray-500">
                <span className="flex items-center gap-1"><FiClock size={12} /> {t.duration}</span>
                <span className="flex items-center gap-1"><FiUsers size={12} /> {t.enrolled}/{t.seats} seats</span>
                <span className="font-medium text-primary-700">{t.fee}</span>
              </div>

              {/* Seat progress */}
              <div>
                <div className="flex justify-between text-xs text-gray-400 mb-1">
                  <span>Seats filled</span>
                  <span>{pct}%</span>
                </div>
                <div className="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                  <div
                    className={`h-full rounded-full transition-all ${isFull ? 'bg-red-500' : 'bg-green-500'}`}
                    style={{ width: `${pct}%` }}
                  />
                </div>
              </div>

              {/* Enroll button */}
              <button
                onClick={() => handleEnroll(t.id)}
                disabled={isFull || isEnrolled}
                className={`w-full flex items-center justify-center gap-2 py-2.5 rounded-xl
                            font-semibold text-sm transition-all duration-200
                            ${isEnrolled
                              ? 'bg-green-100 text-green-700 cursor-default'
                              : isFull
                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                : 'btn-primary'
                            }`}
              >
                {isEnrolled ? (
                  <><FiCheckCircle size={15} /> Enrolled</>
                ) : isFull ? (
                  'No seats available'
                ) : (
                  'Enroll Now'
                )}
              </button>
            </div>
          )
        })}
      </div>
    </div>
  )
}
