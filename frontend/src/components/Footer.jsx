import { Link } from 'react-router-dom'
import { MdWork } from 'react-icons/md'
import {
  FiFacebook, FiTwitter, FiInstagram, FiYoutube,
  FiMail, FiPhone, FiMapPin,
} from 'react-icons/fi'

export default function Footer() {
  const year = new Date().getFullYear()

  return (
    <footer className="bg-navy-900 text-gray-300">
      {/* Main footer content */}
      <div className="max-w-screen-xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

        {/* Brand */}
        <div>
          <div className="flex items-center gap-2 mb-4">
            <div className="w-9 h-9 bg-gradient-to-br from-primary-600 to-blue-400 rounded-xl flex items-center justify-center">
              <MdWork className="text-white" size={20} />
            </div>
            <div>
              <p className="text-white font-bold text-sm">PGRKAM</p>
              <p className="text-gray-400 text-xs">Employment Portal</p>
            </div>
          </div>
          <p className="text-sm text-gray-400 leading-relaxed mb-4">
            Punjab Government's official smart employment guidance system — connecting
            citizens with jobs, training, and career services.
          </p>
          <div className="flex gap-3">
            {[FiFacebook, FiTwitter, FiInstagram, FiYoutube].map((Icon, i) => (
              <a
                key={i}
                href="#"
                className="w-8 h-8 rounded-full bg-white/10 hover:bg-primary-600 flex items-center justify-center
                           transition-colors duration-200"
              >
                <Icon size={14} />
              </a>
            ))}
          </div>
        </div>

        {/* Quick links */}
        <div>
          <h3 className="text-white font-semibold mb-4">Quick Links</h3>
          <ul className="space-y-2 text-sm">
            {[
              { label: 'Government Jobs',    to: '/jobs'        },
              { label: 'Skill Training',     to: '/training'    },
              { label: 'Resume Builder',     to: '/resume'      },
              { label: 'Career Counselling', to: '/counselling' },
              { label: 'Employment Schemes', to: '/services'    },
            ].map(({ label, to }) => (
              <li key={to}>
                <Link to={to} className="hover:text-primary-400 transition-colors">
                  {label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Resources */}
        <div>
          <h3 className="text-white font-semibold mb-4">Resources</h3>
          <ul className="space-y-2 text-sm">
            {[
              { label: 'About PGRKAM', to: '/about'   },
              { label: 'Services',     to: '/services' },
              { label: 'Contact Us',   to: '/contact'  },
              { label: 'Login',        to: '/login'    },
              { label: 'Register',     to: '/register' },
            ].map(({ label, to }) => (
              <li key={to}>
                <Link to={to} className="hover:text-primary-400 transition-colors">
                  {label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Contact */}
        <div>
          <h3 className="text-white font-semibold mb-4">Contact Us</h3>
          <ul className="space-y-3 text-sm">
            <li className="flex items-start gap-3">
              <FiMapPin size={15} className="text-primary-400 flex-shrink-0 mt-0.5" />
              <span>Department of Employment,<br />SCO 153-155, Sector 34-A,<br />Chandigarh – 160022</span>
            </li>
            <li className="flex items-center gap-3">
              <FiPhone size={15} className="text-primary-400 flex-shrink-0" />
              <span>0172-2664000</span>
            </li>
            <li className="flex items-center gap-3">
              <FiMail size={15} className="text-primary-400 flex-shrink-0" />
              <span>helpdesk@pgrkam.gov.in</span>
            </li>
          </ul>
        </div>
      </div>

      {/* Bottom bar */}
      <div className="border-t border-white/10 py-4 px-6">
        <div className="max-w-screen-xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-500">
          <p>© {year} PGRKAM – Government of Punjab. All rights reserved.</p>
          <div className="flex gap-4">
            <a href="#" className="hover:text-gray-300 transition">Privacy Policy</a>
            <a href="#" className="hover:text-gray-300 transition">Terms of Use</a>
            <a href="#" className="hover:text-gray-300 transition">Accessibility</a>
          </div>
        </div>
      </div>
    </footer>
  )
}
