import { useState, useEffect } from 'react'
import {
  FiTarget, FiGlobe, FiUsers, FiAward, FiBriefcase, FiBookOpen,
  FiMapPin, FiCheckCircle, FiStar, FiTrendingUp, FiShield, FiPhone,
  FiMail, FiClock,
} from 'react-icons/fi'
import { statsAPI } from '../api/axios'

export default function About() {
  const [stats, setStats] = useState(null)

  useEffect(() => {
    statsAPI.get().then(({ data }) => setStats(data)).catch(() => {})
  }, [])

  const liveStats = [
    { v: stats ? `${stats.users}+`        : '…', l: 'Registered Users',    icon: FiUsers,      color: 'bg-blue-500'   },
    { v: stats ? `${stats.jobs}+`         : '…', l: 'Jobs Listed',         icon: FiBriefcase,  color: 'bg-green-500'  },
    { v: stats ? `${stats.trainings}+`    : '…', l: 'Training Programs',   icon: FiBookOpen,   color: 'bg-purple-500' },
    { v: stats ? `${stats.applications}+` : '…', l: 'Applications Filed',  icon: FiTrendingUp, color: 'bg-orange-500' },
  ]

  const features = [
    { icon: FiBriefcase, color: 'bg-blue-100 text-blue-700',   title: 'Job Portal',            desc: 'Access thousands of government & private sector jobs across Punjab with one-click applications.' },
    { icon: FiBookOpen,  color: 'bg-purple-100 text-purple-700', title: 'Skill Training',       desc: 'Enroll in free & subsidized skill development programs aligned with industry demands.' },
    { icon: FiAward,     color: 'bg-yellow-100 text-yellow-700', title: 'Govt. Schemes',        desc: 'Explore Punjab government employment schemes, subsidies and self-employment loans.' },
    { icon: FiUsers,     color: 'bg-green-100 text-green-700',   title: 'Career Counselling',   desc: 'Book 1-on-1 career guidance sessions with certified employment counsellors.' },
    { icon: FiShield,    color: 'bg-red-100 text-red-700',       title: 'Resume Builder',       desc: 'Build a professional resume in minutes with our guided resume creation tool.' },
    { icon: FiStar,      color: 'bg-pink-100 text-pink-700',     title: 'Job Alerts',           desc: 'Get instant alerts for jobs matching your profile, skills and preferred district.' },
  ]

  const timeline = [
    { year: '2018', title: 'Portal Launched',         desc: 'PGRKAM portal established by Punjab Government to digitize employment services.' },
    { year: '2019', title: '1 Lakh Registrations',    desc: 'Crossed 1 lakh registered job seekers within the first year of operations.' },
    { year: '2021', title: 'Mobile-First Redesign',   desc: 'Complete redesign for mobile users; training enrollment feature launched.' },
    { year: '2023', title: 'AI-Powered Matching',     desc: 'Smart job matching algorithm introduced to connect seekers with relevant openings.' },
    { year: '2025', title: 'Pan-Punjab Expansion',    desc: 'Services expanded to all 23 districts with dedicated district employment kiosks.' },
  ]

  const offices = [
    { city: 'Chandigarh (HQ)', addr: 'SCO 189-191, Sector 34-A, Chandigarh', phone: '0172-2704933' },
    { city: 'Ludhiana',        addr: 'Employment Office, Ferozepur Road',     phone: '0161-2440422' },
    { city: 'Amritsar',        addr: 'Employment Bhawan, Lawrence Road',      phone: '0183-2501234' },
    { city: 'Jalandhar',       addr: 'District Employment Office, Nakodar Rd',phone: '0181-2235678' },
  ]

  return (
    <div className="bg-white dark:bg-gray-950">

      {/* ── Hero ──────────────────────────────────────────────────────────── */}
      <section className="relative bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 py-24 px-6 overflow-hidden">
        {/* decorative circles */}
        <div className="absolute -top-16 -right-16 w-80 h-80 rounded-full bg-white/5 pointer-events-none" />
        <div className="absolute bottom-0 left-0 w-56 h-56 rounded-full bg-white/5 pointer-events-none" />

        <div className="relative max-w-3xl mx-auto text-center">
          <span className="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6 tracking-wide uppercase">
            Government of Punjab Initiative
          </span>
          <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-5">
            About <span className="text-yellow-300">PGRKAM</span>
          </h1>
          <p className="text-white/75 text-lg max-w-2xl mx-auto leading-relaxed">
            Punjab Government Rozgar Kendra Ate Mukhya Mantri Rozgar Yojana (PGRKAM) is the
            state's official digital employment platform — connecting youth with jobs, training
            and government schemes since 2018.
          </p>
        </div>
      </section>

      {/* ── Live Stats ────────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 -mt-10 relative z-10">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
          {liveStats.map(({ v, l, icon: Icon, color }) => (
            <div key={l} className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
              <div className={`w-12 h-12 ${color} rounded-xl flex items-center justify-center flex-shrink-0`}>
                <Icon className="text-white" size={22} />
              </div>
              <div>
                <p className="text-2xl font-extrabold text-gray-900 dark:text-white leading-none">{v}</p>
                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{l}</p>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* ── Mission & Vision ──────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-8">
        <div className="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/40 dark:to-blue-900/30 border border-blue-200 dark:border-blue-800 p-8">
          <div className="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-200">
            <FiTarget className="text-white" size={26} />
          </div>
          <h2 className="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Our Mission</h2>
          <p className="text-gray-600 dark:text-gray-300 leading-relaxed mb-5">
            To bridge the gap between job seekers and employment opportunities in Punjab through
            a technology-driven, transparent and accessible digital platform that reaches every
            corner of the state.
          </p>
          <ul className="space-y-2">
            {['Reduce youth unemployment in Punjab', 'Transparent job matching process', 'Free access for all citizens'].map(t => (
              <li key={t} className="flex items-center gap-2 text-sm text-blue-800 dark:text-blue-300">
                <FiCheckCircle size={15} /> {t}
              </li>
            ))}
          </ul>
        </div>

        <div className="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/40 dark:to-green-900/30 border border-green-200 dark:border-green-800 p-8">
          <div className="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-200">
            <FiGlobe className="text-white" size={26} />
          </div>
          <h2 className="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Our Vision</h2>
          <p className="text-gray-600 dark:text-gray-300 leading-relaxed mb-5">
            A fully employed Punjab where every youth has access to quality livelihood
            opportunities, skill training and career guidance — regardless of their
            background or location.
          </p>
          <ul className="space-y-2">
            {['Employment for every educated youth', 'Skill Punjab — 1 lakh trained annually', 'Every district with employment kiosk'].map(t => (
              <li key={t} className="flex items-center gap-2 text-sm text-green-800 dark:text-green-300">
                <FiCheckCircle size={15} /> {t}
              </li>
            ))}
          </ul>
        </div>
      </section>

      {/* ── What We Offer ─────────────────────────────────────────────────── */}
      <section className="bg-gray-50 dark:bg-gray-900 py-20 px-6">
        <div className="max-w-screen-xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">What We Offer</h2>
            <p className="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
              PGRKAM brings all employment-related services under one roof — completely free for all Punjab residents.
            </p>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {features.map(({ icon: Icon, color, title, desc }) => (
              <div key={title} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow">
                <div className={`w-12 h-12 ${color} rounded-xl flex items-center justify-center mb-4`}>
                  <Icon size={22} />
                </div>
                <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-2">{title}</h3>
                <p className="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── Journey / Timeline ────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-20">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">Our Journey</h2>
          <p className="text-gray-500 dark:text-gray-400">Milestones that shaped Punjab's employment landscape</p>
        </div>
        <div className="relative">
          <div className="absolute left-1/2 -translate-x-0.5 top-0 bottom-0 w-0.5 bg-primary-200 dark:bg-primary-800 hidden md:block" />
          <div className="space-y-8">
            {timeline.map(({ year, title, desc }, i) => (
              <div key={year} className={`flex flex-col md:flex-row gap-6 items-center ${i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'}`}>
                <div className={`md:w-5/12 ${i % 2 === 0 ? 'md:text-right' : 'md:text-left'}`}>
                  <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <p className="text-sm font-semibold text-primary-600 dark:text-primary-400 mb-1">{year}</p>
                    <p className="font-bold text-gray-900 dark:text-white mb-1">{title}</p>
                    <p className="text-sm text-gray-500 dark:text-gray-400">{desc}</p>
                  </div>
                </div>
                <div className="relative z-10 w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center shadow-lg shadow-primary-200 flex-shrink-0 hidden md:flex">
                  <FiCheckCircle className="text-white" size={18} />
                </div>
                <div className="md:w-5/12" />
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── Leadership ────────────────────────────────────────────────────── */}
      <section className="bg-gray-50 dark:bg-gray-900 py-20 px-6">
        <div className="max-w-screen-xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">Our Leadership</h2>
            <p className="text-gray-500 dark:text-gray-400">The team driving Punjab's employment transformation</p>
          </div>
          <div className="grid sm:grid-cols-3 gap-6">
            {[
              { name: 'Sh. Amritpal Singh IAS', role: 'Secretary, Employment Dept.', dept: 'Govt. of Punjab', avatar: 'A', color: 'from-blue-500 to-blue-700' },
              { name: 'Ms. Simranjit Kaur IAS', role: 'Director, Employment',        dept: 'PGRKAM Portal',   avatar: 'S', color: 'from-purple-500 to-purple-700' },
              { name: 'Mr. Kulwinder Singh',    role: 'IT Head, PGRKAM Portal',      dept: 'Technology Wing', avatar: 'K', color: 'from-green-500 to-green-700' },
            ].map((p) => (
              <div key={p.name} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-lg transition-shadow">
                <div className={`w-20 h-20 rounded-full bg-gradient-to-br ${p.color} flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4 shadow-lg`}>
                  {p.avatar}
                </div>
                <p className="font-extrabold text-gray-900 dark:text-white">{p.name}</p>
                <p className="text-sm text-primary-600 dark:text-primary-400 font-medium mt-1">{p.role}</p>
                <p className="text-xs text-gray-400 mt-0.5">{p.dept}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── District Offices ──────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-20">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-extrabold text-gray-900 dark:text-white mb-3">District Offices</h2>
          <p className="text-gray-500 dark:text-gray-400">Visit your nearest PGRKAM employment office for in-person assistance</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
          {offices.map(({ city, addr, phone }) => (
            <div key={city} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
              <div className="w-10 h-10 bg-primary-100 dark:bg-primary-900/40 rounded-xl flex items-center justify-center mb-4">
                <FiMapPin className="text-primary-700 dark:text-primary-400" size={18} />
              </div>
              <p className="font-bold text-gray-900 dark:text-white text-sm mb-1">{city}</p>
              <p className="text-xs text-gray-500 dark:text-gray-400 mb-3 leading-relaxed">{addr}</p>
              <p className="flex items-center gap-1.5 text-xs text-primary-700 dark:text-primary-400 font-medium">
                <FiPhone size={12} /> {phone}
              </p>
            </div>
          ))}
        </div>
      </section>

      {/* ── Contact CTA ───────────────────────────────────────────────────── */}
      <section className="bg-gradient-to-r from-primary-700 to-primary-900 py-16 px-6">
        <div className="max-w-3xl mx-auto text-center">
          <h2 className="text-2xl font-extrabold text-white mb-3">Get In Touch</h2>
          <p className="text-white/70 mb-8">Have questions about our services? Our team is ready to help you 6 days a week.</p>
          <div className="flex flex-col sm:flex-row justify-center gap-4">
            <a href="mailto:pgrkam@punjab.gov.in"
               className="flex items-center justify-center gap-2 bg-white text-primary-800 font-semibold px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors">
              <FiMail size={16} /> pgrkam@punjab.gov.in
            </a>
            <div className="flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-6 py-3 rounded-xl">
              <FiClock size={16} /> Mon–Sat, 9 AM – 5 PM
            </div>
          </div>
        </div>
      </section>

    </div>
  )
}
