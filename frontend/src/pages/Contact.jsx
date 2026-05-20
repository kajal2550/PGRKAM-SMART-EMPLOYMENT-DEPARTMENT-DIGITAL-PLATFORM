import { useState } from 'react'
import { FiMail, FiPhone, FiMapPin, FiSend, FiCheckCircle } from 'react-icons/fi'
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

  return (
    <div className="max-w-screen-xl mx-auto px-6 py-16">
      <div className="text-center mb-12">
        <h1 className="text-3xl font-extrabold text-gray-900">Contact Us</h1>
        <p className="text-gray-500 mt-3 max-w-lg mx-auto">
          Have a query? Reach out to the PGRKAM helpdesk — we're here to assist you.
        </p>
      </div>

      <div className="grid lg:grid-cols-3 gap-8">
        {/* Contact info */}
        <div className="space-y-4">
          {[
            { icon: FiMapPin, label: 'Address',    value: 'SCO 153-155, Sector 34-A,\nChandigarh – 160022', color: 'text-blue-600', bg: 'bg-blue-100' },
            { icon: FiPhone,  label: 'Phone',       value: '0172-2664000\n18001800000 (Toll Free)', color: 'text-green-600', bg: 'bg-green-100' },
            { icon: FiMail,   label: 'Email',       value: 'helpdesk@pgrkam.gov.in\nsupport@pgrkam.gov.in', color: 'text-purple-600', bg: 'bg-purple-100' },
          ].map(({ icon: Icon, label, value, color, bg }) => (
            <div key={label} className="glass-card p-5 flex items-start gap-4">
              <div className={`w-10 h-10 rounded-xl ${bg} flex items-center justify-center flex-shrink-0`}>
                <Icon className={color} size={18} />
              </div>
              <div>
                <p className="font-semibold text-gray-900 text-sm">{label}</p>
                <p className="text-gray-500 text-sm mt-0.5 whitespace-pre-line">{value}</p>
              </div>
            </div>
          ))}

          {/* Office hours */}
          <div className="glass-card p-5">
            <p className="font-semibold text-gray-900 text-sm mb-2">Office Hours</p>
            <div className="space-y-1 text-sm text-gray-500">
              <p>Mon – Fri: 9:00 AM – 5:00 PM</p>
              <p>Saturday: 9:00 AM – 1:00 PM</p>
              <p>Sunday: Closed</p>
            </div>
          </div>
        </div>

        {/* Contact form */}
        <div className="lg:col-span-2">
          {!submitted ? (
            <div className="glass-card p-8">
              <h2 className="font-bold text-gray-900 mb-6">Send us a Message</h2>
              <form onSubmit={handleSubmit} className="space-y-4">
                <div className="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700 mb-1 block">Full Name *</label>
                    <input type="text" value={form.name}
                      onChange={(e) => setForm({ ...form, name: e.target.value })}
                      placeholder="Your name" className="input-field text-sm" />
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 mb-1 block">Email *</label>
                    <input type="email" value={form.email}
                      onChange={(e) => setForm({ ...form, email: e.target.value })}
                      placeholder="you@example.com" className="input-field text-sm" />
                  </div>
                </div>
                <div className="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label className="text-sm font-medium text-gray-700 mb-1 block">Phone</label>
                    <input type="tel" value={form.phone}
                      onChange={(e) => setForm({ ...form, phone: e.target.value })}
                      placeholder="+91 98765 43210" className="input-field text-sm" />
                  </div>
                  <div>
                    <label className="text-sm font-medium text-gray-700 mb-1 block">Subject</label>
                    <input type="text" value={form.subject}
                      onChange={(e) => setForm({ ...form, subject: e.target.value })}
                      placeholder="e.g., Job Query" className="input-field text-sm" />
                  </div>
                </div>
                <div>
                  <label className="text-sm font-medium text-gray-700 mb-1 block">Message *</label>
                  <textarea rows={5} value={form.message}
                    onChange={(e) => setForm({ ...form, message: e.target.value })}
                    placeholder="Describe your query in detail…"
                    className="input-field text-sm resize-none" />
                </div>
                <button type="submit" className="btn-primary flex items-center gap-2">
                  <FiSend size={15} /> Send Message
                </button>
              </form>
            </div>
          ) : (
            <div className="glass-card p-12 text-center animate-slide-up">
              <FiCheckCircle size={56} className="text-green-500 mx-auto mb-4" />
              <h2 className="text-xl font-bold text-gray-900 mb-2">Message Received!</h2>
              <p className="text-gray-500 text-sm">Our team will reply to {form.email} within 2 business days.</p>
              <button onClick={() => { setForm({ name: '', email: '', phone: '', subject: '', message: '' }); setSub(false) }}
                className="btn-secondary mt-6 text-sm">Send Another</button>
            </div>
          )}
        </div>
      </div>
    </div>
  )
}
