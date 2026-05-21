import { useState, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { FiArrowRight, FiSearch, FiCheckCircle } from 'react-icons/fi'
import ServiceCard from '../components/ServiceCard'
import SuggestionCard from '../components/SuggestionCard'
import { dummyServices, analyseQuery, GUIDANCE_KEYWORDS } from '../utils/helpers'
import { statsAPI } from '../api/axios'

export default function Home() {
  const navigate = useNavigate()
  const [query,       setQuery]       = useState('')
  const [suggestions, setSuggestions] = useState([])
  const [searched,    setSearched]    = useState(false)
  const [stats,       setStats]       = useState(null)

  useEffect(() => {
    statsAPI.get().then(({ data }) => setStats(data)).catch(() => {})
  }, [])

  const liveStats = [
    { value: stats ? `${stats.jobs}+`      : '…', label: 'Active Job Listings'   },
    { value: stats ? `${stats.trainings}+` : '…', label: 'Training Programs'     },
    { value: stats ? `${stats.users}+`     : '…', label: 'Registered Users'      },
    { value: stats ? `${stats.districts}`  : '22', label: 'Districts Covered'    },
  ]

  const handleSearch = (e) => {
    e.preventDefault()
    const results = analyseQuery(query)
    setSuggestions(results)
    setSearched(true)
    if (results.length === 1) navigate(results[0].path)
  }

  return (
    <div>
      {/* ── Hero Section ──────────────────────────────────────────────────── */}
      <section className="relative bg-gradient-primary overflow-hidden">
        {/* Decorative blobs */}
        <div className="absolute top-0 right-0 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2" />
        <div className="absolute bottom-0 left-0 w-72 h-72 bg-primary-400/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2" />

        <div className="relative max-w-screen-xl mx-auto px-6 py-24 text-center">
          {/* Badge */}
          <span className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20
                           text-white/90 text-sm font-medium mb-6">
            <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse" />
            Punjab Government Employment Portal
          </span>

          <h1 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Find Your Path to <br />
            <span className="text-blue-300">Employment Success</span>
          </h1>
          <p className="text-lg text-white/80 max-w-2xl mx-auto mb-10">
            PGRKAM connects Punjab's workforce with government jobs, skill training,
            career counselling, and resume building — all in one smart portal.
          </p>

          {/* Smart search bar */}
          <form onSubmit={handleSearch} className="max-w-2xl mx-auto mb-8">
            <div className="flex gap-2 p-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl">
              <input
                type="text"
                value={query}
                onChange={(e) => { setQuery(e.target.value); setSearched(false) }}
                placeholder='Try: "I need a government job" or "Want skill training"'
                className="flex-1 px-4 py-2.5 bg-transparent text-white placeholder-white/60
                           focus:outline-none text-sm"
              />
              <button
                type="submit"
                className="flex items-center gap-2 px-5 py-2.5 bg-white text-primary-700
                           rounded-xl font-semibold text-sm hover:bg-blue-50 transition"
              >
                <FiSearch size={16} /> Explore
              </button>
            </div>
          </form>

          {/* Suggestion results */}
          {searched && suggestions.length > 0 && (
            <div className="max-w-xl mx-auto space-y-3 mb-8 animate-slide-up">
              {suggestions.map((s, i) => (
                <SuggestionCard key={i} {...s} />
              ))}
            </div>
          )}
          {searched && suggestions.length === 0 && (
            <p className="text-white/70 text-sm mb-6 animate-fade-in">
              No direct match found. Try words like "job", "training", "resume", or "career".
            </p>
          )}

          {/* CTA buttons */}
          <div className="flex flex-wrap gap-3 justify-center">
            <Link to="/register" className="btn-primary bg-white text-primary-700 hover:bg-blue-50">
              Get Started <FiArrowRight size={16} />
            </Link>
            <Link to="/services" className="font-semibold px-6 py-2.5 rounded-xl bg-white text-primary-700 hover:bg-blue-50 transition-all duration-200 shadow-sm active:scale-95">
              Browse Services
            </Link>
          </div>
        </div>
      </section>

      {/* ── Stats Strip ────────────────────────────────────────────────────── */}
      <section className="bg-primary-800">
        <div className="max-w-screen-xl mx-auto px-6 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
          {liveStats.map(({ value, label }) => (
            <div key={label}>
              <p className="text-3xl font-extrabold text-white">{value}</p>
              <p className="text-sm text-primary-200 mt-1">{label}</p>
            </div>
          ))}
        </div>
      </section>

      {/* ── Services Section ────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-20">
        <div className="text-center mb-12">
          <span className="badge badge-blue mb-3">Our Services</span>
          <h2 className="text-3xl font-extrabold text-gray-900">
            Everything You Need, <span className="text-gradient">In One Place</span>
          </h2>
          <p className="text-gray-500 mt-3 max-w-xl mx-auto">
            Explore Punjab's comprehensive employment ecosystem built for every citizen.
          </p>
        </div>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {dummyServices.map((s) => (
            <ServiceCard key={s.id} {...s} />
          ))}
        </div>
        <div className="text-center mt-10">
          <Link to="/services" className="btn-primary">
            View All Services <FiArrowRight size={16} />
          </Link>
        </div>
      </section>

      {/* ── Smart Guidance Feature Section ──────────────────────────────────── */}
      <section className="bg-gradient-to-br from-primary-50 to-blue-50 py-20">
        <div className="max-w-screen-xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
          <div>
            <span className="badge badge-blue mb-3">AI Guidance</span>
            <h2 className="text-3xl font-extrabold text-gray-900 mb-4">
              Smart Guidance at Your Fingertips
            </h2>
            <p className="text-gray-600 mb-6 leading-relaxed">
              Not sure where to start? Our AI-powered guidance system listens to what you
              need and instantly points you to the right service — no browsing required.
            </p>
            <ul className="space-y-3">
              {[
                'Type in plain language – no forms needed',
                'Instant module recommendations',
                'Available 24/7 for every citizen',
                'Works in Hindi and English',
              ].map((f) => (
                <li key={f} className="flex items-center gap-3 text-gray-700">
                  <FiCheckCircle className="text-green-500 flex-shrink-0" size={18} />
                  {f}
                </li>
              ))}
            </ul>
            <button
              onClick={() => {/* QueryBox handles this via floating button */}}
              className="btn-primary mt-8"
            >
              Try It Now 🤖
            </button>
          </div>

          {/* Chat demo preview */}
          <div className="glass-card p-6 space-y-4">
            <div className="flex items-center gap-2 mb-4">
              <div className="w-3 h-3 rounded-full bg-red-400" />
              <div className="w-3 h-3 rounded-full bg-yellow-400" />
              <div className="w-3 h-3 rounded-full bg-green-400" />
              <span className="ml-2 text-sm text-gray-400">Guidance Assistant</span>
            </div>
            {[
              { from: 'bot',  text: 'Hello! What are you looking for today?' },
              { from: 'user', text: 'I need a government job in Chandigarh' },
              { from: 'bot',  text: 'Great! I found 24 government job listings in Chandigarh. Redirecting you to the Jobs module…' },
            ].map((m, i) => (
              <div key={i} className={`flex ${m.from === 'user' ? 'justify-end' : 'justify-start'}`}>
                <div className={m.from === 'user' ? 'chat-bubble-user' : 'chat-bubble-bot'}>
                  <p className="text-sm">{m.text}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── CTA Banner ──────────────────────────────────────────────────────── */}
      <section className="bg-gradient-primary py-16 text-center">
        <h2 className="text-3xl font-extrabold text-white mb-4">Ready to find your opportunity?</h2>
        <p className="text-white/70 mb-8 max-w-lg mx-auto">
          Join over 3 lakh citizens already using PGRKAM to build their careers.
        </p>
        <Link to="/register" className="inline-flex items-center gap-2 px-8 py-3 bg-white
                                         text-primary-700 font-bold rounded-2xl hover:bg-blue-50 transition shadow-lg">
          Create Free Account <FiArrowRight size={18} />
        </Link>
      </section>
    </div>
  )
}
