import { useState } from 'react'
import {
  FiMail, FiPhone, FiMapPin, FiSend, FiCheckCircle,
  FiClock, FiMessageCircle, FiHeadphones, FiAlertCircle,
} from 'react-icons/fi'
import toast from 'react-hot-toast'

export default function Contact() {
  const [form, setForm]     = useState({ name: '', email: '', phone: '', subject: '', message: '' })
  const [submitted, setSub] = useState(false)

  const handleSubmit = (e) => {
    e.preventDefault()
    if (!form.name || !form.email || !form.message) { toast.error('Please fill required fields'); return }
    setSub(true)
    toast.success('Message sent! We will respond within 2 business days.')
  }

  const faqs = [
    { q: 'How do I register on PGRKAM?',      a: 'Click the Register button, fill in your details and verify your email to activate your free account.' },
    { q: 'Is this portal free to use?',        a: 'Yes, PGRKAM is 100% free for all Punjab residents — job seekers and employers alike.' },
    { q: 'How can I apply for a job?',         a: 'Browse the Jobs section, click on a listing and hit "Apply Now". Track your applications under My Applications.' },
    { q: 'What documents are needed?',         a: 'Aadhaar card, educational certificates, and a recent passport-size photograph are commonly required.' },
  ]

  return (
    <div className="bg-white dark:bg-gray-950">

      {/* ── Hero ─────────────────────────────────────────────────────────── */}
      <section className="relative bg-gradient-to-br from-primary-700 via-primary-800 to-primary-900 py-20 px-6 overflow-hidden text-center">
        <div className="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-white/5 pointer-events-none" />
        <div className="absolute bottom-0 -left-10 w-48 h-48 rounded-full bg-white/5 pointer-events-none" />
        <div className="relative max-w-2xl mx-auto">
          <span className="inline-block bg-white/10 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-5 tracking-wide uppercase">
            We're here to help
          </span>
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-4">Contact Us</h1>
          <p className="text-white/70 text-lg">
            Have a question, concern or feedback? Reach out to the PGRKAM helpdesk — our team responds within 2 business days.
          </p>
        </div>
      </section>

      {/* ── Support Cards ─────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 -mt-8 relative z-10">
        <div className="grid sm:grid-cols-3 gap-4">
          {[
            { icon: FiPhone,        color: 'bg-green-500',  title: 'Call Us',       sub: '0172-2664000',             note: 'Toll Free: 18001800000' },
            { icon: FiMail,         color: 'bg-blue-500',   title: 'Email Support', sub: 'helpdesk@pgrkam.gov.in',   note: 'Reply within 48 hours'  },
            { icon: FiHeadphones,   color: 'bg-purple-500', title: 'Live Chat',     sub: 'Chat with our bot',        note: 'Available 24 × 7'       },
          ].map(({ icon: Icon, color, title, sub, note }) => (
            <div key={title} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-lg p-5 flex items-center gap-4">
              <div className={`w-12 h-12 ${color} rounded-xl flex items-center justify-center flex-shrink-0`}>
                <Icon className="text-white" size={22} />
              </div>
              <div>
                <p className="font-bold text-gray-900 dark:text-white text-sm">{title}</p>
                <p className="text-gray-700 dark:text-gray-300 text-sm">{sub}</p>
                <p className="text-gray-400 text-xs">{note}</p>
              </div>
            </div>
          ))}
        </div>
      </section>

      {/* ── Main Content ──────────────────────────────────────────────────── */}
      <section className="max-w-screen-xl mx-auto px-6 py-16 grid lg:grid-cols-3 gap-8">

        {/* Left – Info + Hours */}
        <div className="space-y-5">

          {/* Address */}
          <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 flex items-start gap-4">
            <div className="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
              <FiMapPin className="text-blue-600 dark:text-blue-400" size={18} />
            </div>
            <div>
              <p className="font-semibold text-gray-900 dark:text-white text-sm mb-0.5">Headquarters</p>
              <p className="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">SCO 153-155, Sector 34-A,<br />Chandigarh – 160022</p>
            </div>
          </div>

          {/* Phone */}
          <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 flex items-start gap-4">
            <div className="w-10 h-10 bg-green-100 dark:bg-green-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
              <FiPhone className="text-green-600 dark:text-green-400" size={18} />
            </div>
            <div>
              <p className="font-semibold text-gray-900 dark:text-white text-sm mb-0.5">Phone</p>
              <p className="text-gray-500 dark:text-gray-400 text-sm">0172-2664000</p>
              <p className="text-green-600 dark:text-green-400 text-xs font-medium mt-0.5">18001800000 (Toll Free)</p>
            </div>
          </div>

          {/* Email */}
          <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 flex items-start gap-4">
            <div className="w-10 h-10 bg-purple-100 dark:bg-purple-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
              <FiMail className="text-purple-600 dark:text-purple-400" size={18} />
            </div>
            <div>
              <p className="font-semibold text-gray-900 dark:text-white text-sm mb-0.5">Email</p>
              <p className="text-gray-500 dark:text-gray-400 text-sm">helpdesk@pgrkam.gov.in</p>
              <p className="text-gray-500 dark:text-gray-400 text-sm">support@pgrkam.gov.in</p>
            </div>
          </div>

          {/* Office Hours */}
          <div className="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-950/40 dark:to-primary-900/30 border border-primary-200 dark:border-primary-800 rounded-2xl p-5">
            <div className="flex items-center gap-2 mb-3">
              <FiClock className="text-primary-700 dark:text-primary-400" size={16} />
              <p className="font-semibold text-primary-900 dark:text-primary-200 text-sm">Office Hours</p>
            </div>
            <div className="space-y-2 text-sm">
              <div className="flex justify-between">
                <span className="text-gray-600 dark:text-gray-400">Mon – Fri</span>
                <span className="font-medium text-gray-900 dark:text-white">9:00 AM – 5:00 PM</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600 dark:text-gray-400">Saturday</span>
                <span className="font-medium text-gray-900 dark:text-white">9:00 AM – 1:00 PM</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600 dark:text-gray-400">Sunday</span>
                <span className="font-medium text-red-500">Closed</span>
              </div>
            </div>
          </div>

          {/* Quick tip */}
          <div className="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-2xl p-4 flex gap-3">
            <FiAlertCircle className="text-yellow-600 flex-shrink-0 mt-0.5" size={16} />
            <p className="text-xs text-yellow-800 dark:text-yellow-300 leading-relaxed">
              For urgent issues, call the toll-free number during office hours for the fastest response.
            </p>
          </div>
        </div>

        {/* Right – Form */}
        <div className="lg:col-span-2">
          {!submitted ? (
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-8">
              <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 bg-primary-100 dark:bg-primary-900/40 rounded-xl flex items-center justify-center">
                  <FiMessageCircle className="text-primary-700 dark:text-primary-400" size={20} />
                </div>
                <div>
                  <h2 className="font-extrabold text-gray-900 dark:text-white">Send us a Message</h2>
                  <p className="text-xs text-gray-400">We'll get back to you within 2 business days</p>
                </div>
              </div>

              <form onSubmit={handleSubmit} className="space-y-4">
                <div className="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 block">Full Name <span className="text-red-500">*</span></label>
                    <input type="text" value={form.name}
                      onChange={(e) => setForm({ ...form, name: e.target.value })}
                      placeholder="Your full name"
                      className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 block">Email <span className="text-red-500">*</span></label>
                    <input type="email" value={form.email}
                      onChange={(e) => setForm({ ...form, email: e.target.value })}
                      placeholder="you@example.com"
                      className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
                  </div>
                </div>

                <div className="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 block">Phone</label>
                    <input type="tel" value={form.phone}
                      onChange={(e) => setForm({ ...form, phone: e.target.value })}
                      placeholder="+91 98765 43210"
                      className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 transition" />
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 block">Subject</label>
                    <select value={form.subject}
                      onChange={(e) => setForm({ ...form, subject: e.target.value })}
                      className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                      <option value="">Select a subject…</option>
                      <option>Job Query</option>
                      <option>Training Enrollment</option>
                      <option>Technical Issue</option>
                      <option>Account / Login</option>
                      <option>Government Scheme</option>
                      <option>Other</option>
                    </select>
                  </div>
                </div>

                <div>
                  <label className="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5 block">Message <span className="text-red-500">*</span></label>
                  <textarea rows={5} value={form.message}
                    onChange={(e) => setForm({ ...form, message: e.target.value })}
                    placeholder="Describe your query in detail…"
                    className="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent placeholder-gray-400 resize-none transition" />
                </div>

                <button type="submit"
                  className="flex items-center gap-2 bg-primary-700 hover:bg-primary-800 text-white font-semibold px-7 py-3 rounded-xl transition-colors shadow-lg shadow-primary-200 dark:shadow-none">
                  <FiSend size={15} /> Send Message
                </button>
              </form>
            </div>
          ) : (
            <div className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-14 text-center">
              <div className="w-20 h-20 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center mx-auto mb-5">
                <FiCheckCircle size={40} className="text-green-500" />
              </div>
              <h2 className="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">Message Sent!</h2>
              <p className="text-gray-500 dark:text-gray-400 text-sm mb-1">We've received your message.</p>
              <p className="text-gray-500 dark:text-gray-400 text-sm">Our team will reply to <span className="font-semibold text-gray-700 dark:text-gray-300">{form.email}</span> within 2 business days.</p>
              <button onClick={() => { setForm({ name: '', email: '', phone: '', subject: '', message: '' }); setSub(false) }}
                className="mt-7 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                Send Another Message
              </button>
            </div>
          )}
        </div>
      </section>

      {/* ── FAQ ───────────────────────────────────────────────────────────── */}
      <section className="bg-gray-50 dark:bg-gray-900 py-16 px-6">
        <div className="max-w-screen-xl mx-auto">
          <div className="text-center mb-10">
            <h2 className="text-2xl font-extrabold text-gray-900 dark:text-white mb-2">Frequently Asked Questions</h2>
            <p className="text-gray-500 dark:text-gray-400 text-sm">Quick answers to common queries</p>
          </div>
          <div className="grid md:grid-cols-2 gap-5 max-w-4xl mx-auto">
            {faqs.map(({ q, a }) => (
              <div key={q} className="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
                <p className="font-semibold text-gray-900 dark:text-white text-sm mb-2 flex items-start gap-2">
                  <span className="w-5 h-5 bg-primary-100 dark:bg-primary-900/40 text-primary-700 dark:text-primary-400 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">Q</span>
                  {q}
                </p>
                <p className="text-gray-500 dark:text-gray-400 text-sm leading-relaxed pl-7">{a}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── CTA Banner ────────────────────────────────────────────────────── */}
      <section className="bg-gradient-to-r from-primary-700 to-primary-900 py-14 px-6 text-center">
        <h2 className="text-2xl font-extrabold text-white mb-2">Still need help?</h2>
        <p className="text-white/70 mb-6 text-sm">Visit your nearest District Employment Office or call our toll-free number.</p>
        <a href="tel:18001800000"
          className="inline-flex items-center gap-2 bg-white text-primary-800 font-bold px-7 py-3 rounded-xl hover:bg-gray-100 transition-colors shadow-lg text-sm">
          <FiPhone size={16} /> Call 18001800000 (Free)
        </a>
      </section>

    </div>
  )
}
